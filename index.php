<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Async Job Monitor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="brand">
        <div class="logo">⌁</div>
        <div>
            <h2>Async Job Monitor</h2>
            <p>Celery + Redis + FastAPI</p>
        </div>
    </div>

    <nav>
        <a class="active">⚙ Dashboard</a>
        <a>▤ Jobs</a>
        <a>♟ Workers</a>
        <a>◎ Queues</a>
        <a>▧ Logs</a>
        <a>⚙ Settings</a>
    </nav>

    <div class="start-card">
        <h3>⚡ Start New Jobs</h3>
        <p>Create demo jobs to see Celery running in real time.</p>
        <button id="startJobsBtn">▷ Start 10 Jobs</button>
    </div>
</aside>

<main class="main">
    <header class="topbar">
        <div>
            <h1>Dashboard <span id="systemStatus">● System Online</span></h1>
            <p>Real-time overview of your background jobs</p>
        </div>

        <div>
            <span id="lastUpdated">Last updated: --</span>
            <button id="refreshBtn">↻ Auto Refresh</button>
        </div>
    </header>
      <section class="cards">
        <div class="card blue">
            <span>▤</span>
            <div>
                <h3>Queued</h3>
                <strong id="queuedCount">0</strong>
                <p>Jobs waiting</p>
            </div>
        </div>

        <div class="card yellow">
            <span>▷</span>
            <div>
                <h3>Running</h3>
                <strong id="runningCount">0</strong>
                <p>Jobs in progress</p>
            </div>
        </div>

        <div class="card green">
            <span>✓</span>
            <div>
                <h3>Completed</h3>
                <strong id="completedCount">0</strong>
                <p>Jobs finished</p>
            </div>
        </div>

        <div class="card red">
            <span>×</span>
            <div>
                <h3>Failed</h3>
                <strong id="failedCount">0</strong>
                <p>Jobs failed</p>
            </div>
        </div>

        <div class="card purple">
            <span>☷</span>
            <div>
                <h3>Total Jobs</h3>
                <strong id="totalCount">0</strong>
                <p>All time</p>
            </div>
        </div>
          </section>

    <section class="grid">
        <div class="panel">
            <h2>Job Progress Overview</h2>

            <div class="stack-bar">
                <div id="queuedBar" class="bar queued"></div>
                <div id="runningBar" class="bar running"></div>
                <div id="completedBar" class="bar completed"></div>
                <div id="failedBar" class="bar failed"></div>
            </div>

            <div class="legend">
                <p>● Queued <span id="queuedPercent">0%</span></p>
                <p>● Running <span id="runningPercent">0%</span></p>
                <p>● Completed <span id="completedPercent">0%</span></p>
                <p>● Failed <span id="failedPercent">0%</span></p>
            </div>
        </div>

        <div class="panel">
            <h2>System Info</h2>
            <div class="info-row">♟ Celery Workers <span id="workersOnline">Online</span></div>
            <div class="info-row">◎ Redis Queue <span>Connected</span></div>
            <div class="info-row">⚡ FastAPI Status <span>Online</span></div>
            <div class="info-row">▤ Database <span>Memory Demo</span></div>
        </div>
    </section>

    <section class="bottom-grid">
        <div class="panel">
            <h2>Recent Jobs</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Job Name</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody id="jobsTable"></tbody>
            </table>
        </div>
            <div class="panel">
            <h2>Recent Activity</h2>
            <div id="activityList"></div>
        </div>
    </section>
</main>

<script src="js/app.js"></script>
</body>
</html>