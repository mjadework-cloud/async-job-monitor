from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware

from app.redis_store import (
    create_job,
    get_jobs,
    get_activity,
    next_job_id,
)
from app.tasks.sample import process_job

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=[
        "http://192.168.1.101",
        "http://192.168.1.101:8080",
        "http://localhost",
        "http://localhost:8080",
        "http://127.0.0.1",
        "http://127.0.0.1:8080",
    ],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def root():
    return {
        "message": "Async Job Monitor API is running"
    }

@app.post("/run-task")
def run_task():
    created = []

    for _ in range(10):
        job_id = next_job_id()

        create_job(job_id)

        process_job.delay(job_id)

        created.append(job_id)

    return {
        "message": "10 jobs queued",
        "job_ids": created,
    }

@app.get("/dashboard")
def dashboard():
    jobs = get_jobs()

    summary = {
        "queued": sum(1 for job in jobs if job["status"] == "queued"),
        "running": sum(1 for job in jobs if job["status"] == "running"),
        "completed": sum(1 for job in jobs if job["status"] == "completed"),
        "failed": sum(1 for job in jobs if job["status"] == "failed"),
        "total": len(jobs),
    }

    return {
        "summary": summary,
        "jobs": jobs,
        "activity": get_activity(),
    }
