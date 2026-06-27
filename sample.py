import time
from app.celery_app import celery_app
from app.redis_store import update_job, add_activity

@celery_app.task
def process_job(job_id: int):
    update_job(job_id, status="running", progress=10)

    add_activity(
        f"Job #{job_id} started",
        f"Demo Background Job {job_id}",
    )

    for progress in [20, 40, 60, 80, 100]:
        time.sleep(1)
        update_job(job_id, progress=progress)

    update_job(
        job_id,
        status="completed",
        progress=100,
        result="Task Finished",
    )

    add_activity(
        f"Job #{job_id} completed",
        f"Demo Background Job {job_id}",
    )

    return "Task Finished"