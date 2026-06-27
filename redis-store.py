import json
import redis
from datetime import datetime

r = redis.Redis(
    host="127.0.0.1",
    port=6379,
    db=2,
    decode_responses=True,
)

def now():
    return datetime.now().strftime("%H:%M:%S")

def create_job(job_id: int):
    job = {
        "id": job_id,
        "name": f"Demo Background Job {job_id}",
        "status": "queued",
        "progress": 0,
        "result": "",
        "created_at": now(),
    }

    r.hset(f"job:{job_id}", mapping={
        key: json.dumps(value) for key, value in job.items()
    })

    r.lpush("jobs", job_id)
    add_activity(f"Job #{job_id} queued", job["name"])

def update_job(job_id: int, **fields):
    r.hset(f"job:{job_id}", mapping={
        key: json.dumps(value) for key, value in fields.items()
    })

def get_job(job_id: int):
    raw = r.hgetall(f"job:{job_id}")

    return {
        key: json.loads(value)
        for key, value in raw.items()
    }

def get_jobs():
    ids = r.lrange("jobs", 0, -1)
        return [get_job(int(job_id)) for job_id in ids]

def add_activity(title: str, message: str):
    item = {
        "title": title,
        "message": message,
        "time": now(),
    }

    r.lpush("activity", json.dumps(item))
    r.ltrim("activity", 0, 20)

def get_activity():
    items = r.lrange("activity", 0, 20)
    return [json.loads(item) for item in items]

def next_job_id():
    return r.incr("job_counter")