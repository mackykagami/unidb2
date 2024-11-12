<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
     :root {
    --primary-color: #2C2F33; /* Steely gray */
    --secondary-color: #D62828; /* Stark red */
    --accent-color: #F7C948; /* Gold/yellow for accents */
    --background-color: #1E2125; /* Dark metallic background */
    --card-background: #2C2F33;
    --text-dark: #E4E6EB;
    --text-light: #FFFFFF;
}

/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    background: var(--background-color);
    color: var(--text-dark);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Hero Header */
.hero-header {
    background: var(--primary-color);
    color: var(--text-light);
    padding: 3rem 1rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    border-bottom: 3px solid var(--secondary-color);
    position: relative;
    overflow: hidden;
    animation: slideInFromTop 0.8s ease-out;
}

.hero-header::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.1), transparent);
    transform: translate(-50%, -50%);
    pointer-events: none;
    z-index: 0;
}

.hero-header h1 {
    font-size: 3rem;
    color: var(--secondary-color);
    font-weight: 700;
    text-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
    position: relative;
    z-index: 1;
    animation: fadeInUp 0.8s ease;
}

.hero-header p {
    font-size: 1.2rem;
    font-weight: 300;
    color: var(--text-light);
    position: relative;
    z-index: 1;
    text-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
}

/* Navigation Menu */
.nav-container {
    padding: 2rem 0;
    display: flex;
    justify-content: center;
    flex-grow: 1;
}

.nav-menu {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    max-width: 1000px;
    padding: 0 1rem;
}

.nav-item {
    background: var(--card-background);
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s;
    position: relative;
    overflow: hidden;
    animation: scaleIn 0.5s ease forwards;
}

.nav-item:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    background: linear-gradient(135deg, #333A40, #2C2F33);
}

.nav-item::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.05);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s;
}

.nav-item:hover::after {
    opacity: 1;
}

.nav-item a {
    color: var(--text-dark);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 1;
}

.nav-item i {
    font-size: 2.5rem;
    color: var(--accent-color);
    margin-bottom: 1rem;
    transition: color 0.3s ease;
}

.nav-item i:hover {
    color: var(--secondary-color);
}

.nav-item h3 {
    font-size: 1.2rem;
    margin-top: 0.5rem;
    color: var(--accent-color);
}

/* Footer */
footer {
    background: var(--primary-color);
    color: var(--text-light);
    text-align: center;
    padding: 1rem;
    font-size: 0.9rem;
    border-top: 2px solid var(--secondary-color);
    box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.3);
}

/* Dynamic Icon Button */
.icon-btn {
    background: var(--primary-color);
    color: var(--accent-color);
    padding: 12px;
    border-radius: 50%;
    font-size: 1.5rem;
    border: 2px solid var(--primary-color);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    cursor: pointer;
    transition: all 0.4s ease;
    animation: pulse 2s infinite;
}

.icon-btn:hover {
    background-color: var(--secondary-color);
    color: var(--text-light);
    box-shadow: 0 8px 20px rgba(255, 40, 40, 0.6);
    transform: translateY(-4px) scale(1.1);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInFromTop {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes scaleIn {
    from {
        transform: scale(0.95);
        opacity: 0.8;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 10px rgba(255, 200, 50, 0.3), 0 0 30px rgba(255, 200, 50, 0.2);
        transform: rotate(0deg);
    }
    50% {
        box-shadow: 0 0 20px rgba(255, 200, 50, 0.6), 0 0 40px rgba(255, 200, 50, 0.4);
        transform: rotate(2deg);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .hero-header h1 {
        font-size: 2.2rem;
    }
}

    </style>
</head>
<body>
    <header class="hero-header">
        <h1>University Management System</h1>
    </header>

    <nav class="nav-container">
        <div class="nav-menu">
            <div class="nav-item">
                <a href="instructor.php">
                    <h3>Manage Instructors</h3>
                </a>
            </div>
            <div class="nav-item">
                <a href="department.php">
                    <h3>Manage Departments</h3>
                </a>
            </div>
            <div class="nav-item">
                <a href="course.php">
                    <h3>Manage Courses</h3>
                </a>
            </div>
            <div class="nav-item">
                <a href="classroom.php">
                    <h3>Manage Classrooms</h3>
                </a>
            </div>
            <div class="nav-item">
                <a href="timeslot.php">
                    <h3>Manage Time Slots</h3>
                </a>
            </div>
            <div class="nav-item">
                <a href="student.php">
                    <h3>Manage Students</h3>
                </a>
            </div>
        </div>
    </nav>
</body>
</html>
