const API_BASE = "http://192.168.1.101:8000";

document.getElementById("startJobsBtn").addEventListener("click", async () => {
    await fetch(`${API_BASE}/run-task`, {
        method: "POST"
    });

    loadDashboard();
});

document.getElementById("refreshBtn").addEventListener("click", loadDashboard);

async function loadDashboard() {
    const response = await fetch(`${API_BASE}/dashboard`);
    const data = await response.json();

    updateCounts(data.summary);
    updateBars(data.summary);
    updateJobs(data.jobs);
    updateActivity(data.activity);

    document.getElementById("lastUpdated").innerText =
        "Last updated: " + new Date().toLocaleTimeString();
}

function updateCounts(summary) {
    document.getElementById("queuedCount").innerText = summary.queued;
    document.getElementById("runningCount").innerText = summary.running;
    document.getElementById("completedCount").innerText = summary.completed;
    document.getElementById("failedCount").innerText = summary.failed;
    document.getElementById("totalCount").innerText = summary.total;
}

function updateBars(summary) {
    const total = summary.total || 1;

    const queued = Math.round((summary.queued / total) * 100);
    const running = Math.round((summary.running / total) * 100);
    const completed = Math.round((summary.completed / total) * 100);
    const failed = Math.round((summary.failed / total) * 100);

    document.getElementById("queuedBar").style.width = queued + "%";
    document.getElementById("runningBar").style.width = running + "%";
    document.getElementById("completedBar").style.width = completed + "%";
    document.getElementById("failedBar").style.width = failed + "%";

        document.getElementById("queuedPercent").innerText = `${summary.queued} (${queued}%)`;
    document.getElementById("runningPercent").innerText = `${summary.running} (${running}%)`;
    document.getElementById("completedPercent").innerText = `${summary.completed} (${completed}%)`;
    document.getElementById("failedPercent").innerText = `${summary.failed} (${failed}%)`;
}

function updateJobs(jobs) {
    const tbody = document.getElementById("jobsTable");
    tbody.innerHTML = "";

    jobs.forEach(job => {
        tbody.innerHTML += `
            <tr>
                <td>#${job.id}</td>
                <td>${job.name}</td>
                <td><span class="badge ${job.status}">${job.status}</span></td>
                <td>
                    ${job.progress}%
                    <div class="progress-track">
                        <div class="progress-fill" style="width:${job.progress}%"></div>
                    </div>
                </td>
                <td>${job.result || "-"}</td>
            </tr>
        `;
    });
}

function updateActivity(activity) {
    const list = document.getElementById("activityList");
    list.innerHTML = "";

    activity.forEach(item => {
        list.innerHTML += `
            <div class="activity-item">
                <strong>${item.title}</strong>
                <small>${item.message}</small>
            </div>
        `;
    });
}

loadDashboard();
setInterval(loadDashboard, 2000);