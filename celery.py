celery_app = Celery(
    "async_job_monitor",
    broker="redis://127.0.0.1:6379/0",
    backend="redis://127.0.0.1:6379/1",
    include=["app.tasks.sample"],
)

celery_app.conf.update(
    task_track_started=True,
    worker_prefetch_multiplier=1,
)
