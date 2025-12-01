<?php
// PHP code for contact form handling and database connection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root"; // Change if needed
    $password = ""; // Change if needed
    $dbname = "portfolio"; // Database name
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Get form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    
    // Insert data into database
    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error: Could not send message. Please try again.');</script>";
    }
    
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Portfolio — Basharat Iqbal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg: #0b1016;
            --panel: #0f1720;
            --muted: #9aa6b2;
            --accent: #ff6b5c;
            --glass: rgba(255,255,255,0.03);
            --radius: 14px;
            --text: #e7eef6;
        }
        
        [data-theme="light"] {
            --bg: #f6f8fb;
            --panel: #ffffff;
            --muted: #6b7280;
            --accent: #ff6b5c;
            --glass: rgba(0,0,0,0.03);
            --text: #0b1220;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html, body {
            height: 100%;
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.45;
            scroll-behavior: smooth;
            transition: background 0.3s, color 0.3s;
        }
        
        /* Layout */
        .wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            position: sticky;
            top: 0;
            background: var(--bg);
            backdrop-filter: blur(10px);
            z-index: 100;
        }
        .logo {
            font-weight: 800;
            letter-spacing: 0.2px;
            text-decoration: none;
            color: var(--text);
            font-size: 1.2rem;
        }
        nav {
            display: flex;
            gap: 14px;
            align-items: center;
        }
        nav a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.3s;
        }
        nav a:hover {
            color: var(--accent);
        }
        .burger {
            display: none;
            background: none;
            border: 0;
            color: var(--text);
            font-size: 22px;
            cursor: pointer;
        }
        
        /* Hero Section */
        .hero {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 28px;
            align-items: center;
            padding: 28px 0;
            min-height: 80vh;
        }
        .hello {
            color: var(--accent);
            font-weight: 800;
            margin: 0;
        }
        h1 {
            font-size: 40px;
            margin: 6px 0 10px;
        }
        .lead {
            color: var(--muted);
            max-width: 560px;
            margin-bottom: 18px;
        }
        .cta {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 16px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: var(--accent);
            color: #fff;
        }
        .btn-primary:hover {
            background: #ff5544;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 92, 0.3);
        }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--muted);
            color: var(--muted);
        }
        .btn-outline:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-2px);
        }
        
        .skills {
            display: flex;
            gap: 10px;
            list-style: none;
            padding: 0;
            color: var(--muted);
            margin-top: 14px;
            flex-wrap: wrap;
        }
        .skills li {
            background: var(--glass);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
        }
        
        /* Hero Right Card */
        .card {
            background: linear-gradient(180deg, var(--glass), transparent);
            padding: 18px;
            border-radius: var(--radius);
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .ring {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 30% 30%, rgba(255,107,92,0.10), transparent 30%), var(--glass);
            padding: 12px;
        }
        .profile {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid var(--glass);
            display: block;
            transition: transform .45s cubic-bezier(.2,.9,.2,1);
        }
        .profile:hover {
            transform: scale(1.03) rotate(-1deg);
        }
        .stats {
            display: flex;
            gap: 16px;
            margin-top: 14px;
            color: var(--muted);
            width: 100%;
            justify-content: space-around;
        }
        .stats strong {
            color: var(--text);
            font-size: 18px;
            display: block;
            text-align: center;
        }
        .stats span {
            display: block;
            text-align: center;
            font-size: 12px;
        }
        
        /* Sections */
        section {
            padding: 28px 0;
        }
        h2 {
            font-size: 32px;
            margin-bottom: 16px;
            position: relative;
            display: inline-block;
        }
        h2::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: var(--accent);
            bottom: -8px;
            left: 0;
            border-radius: 2px;
        }
        
        /* About Section */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            margin-top: 12px;
        }
        .about-list {
            list-style: none;
            padding: 0;
            color: var(--muted);
        }
        .about-list li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 20px;
        }
        .about-list li::before {
            content: '▸';
            position: absolute;
            left: 0;
            color: var(--accent);
        }
        
        /* Resume Section */
        .resume-container {
            background: var(--panel);
            border-radius: var(--radius);
            padding: 24px;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .resume-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--glass);
        }
        .resume-name {
            font-size: 28px;
            color: var(--text);
        }
        .resume-contact {
            color: var(--muted);
            font-size: 14px;
        }
        .resume-section {
            margin-bottom: 24px;
        }
        .resume-section h3 {
            color: var(--accent);
            margin-bottom: 12px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .resume-item {
            margin-bottom: 16px;
            padding-left: 20px;
            border-left: 2px solid rgba(255,107,92,0.3);
        }
        .resume-item h4 {
            color: var(--text);
            margin-bottom: 4px;
        }
        .resume-item .date {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .resume-item p {
            color: var(--muted);
            font-size: 14px;
        }
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 12px;
        }
        .skill-item {
            background: var(--glass);
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        .skill-item:hover {
            transform: translateY(-5px);
            background: rgba(255,107,92,0.1);
        }
        .skill-icon {
            font-size: 24px;
            color: var(--accent);
        }
        
        /* Progress bars for skills */
        .skill-level {
            width: 100%;
            background: var(--glass);
            border-radius: 10px;
            height: 6px;
            margin-top: 5px;
            overflow: hidden;
        }
        .skill-progress {
            height: 100%;
            background: var(--accent);
            border-radius: 10px;
        }
        
        /* Projects Section */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .project {
            background: var(--panel);
            padding: 14px;
            border-radius: 12px;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: flex-start;
            transition: transform .35s ease, box-shadow .35s ease;
            cursor: pointer;
        }
        .project:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0,0,0,0.1);
        }
        .project .thumb {
            height: 100px;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(255,107,92,0.05), rgba(0,0,0,0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 32px;
        }
        .project h3 {
            color: var(--text);
            font-size: 16px;
        }
        .project p {
            color: var(--muted);
            font-size: 14px;
        }
        .project-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: auto;
        }
        .project-tag {
            background: rgba(255,107,92,0.1);
            color: var(--accent);
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        
        /* Contact Section */
        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 720px;
        }
        .row {
            display: flex;
            gap: 12px;
        }
        input, textarea {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--glass);
            background: var(--panel);
            color: var(--text);
            outline: none;
            font-size: 14px;
            flex: 1;
            transition: border-color 0.3s;
        }
        input:focus, textarea:focus {
            border-color: var(--accent);
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        .form-msg {
            color: var(--accent);
            min-height: 20px;
        }
        
        /* Footer */
        footer {
            border-top: 1px solid var(--glass);
            padding-top: 18px;
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--muted);
        }
        .social-links {
            display: flex;
            gap: 12px;
        }
        .social-links a {
            color: var(--muted);
            text-decoration: none;
            transition: color 0.3s;
        }
        .social-links a:hover {
            color: var(--accent);
        }
        
        /* Responsive Design */
        @media (max-width: 980px) {
            .hero {
                grid-template-columns: 1fr;
            }
            .card {
                order: -1;
                margin-bottom: 18px;
            }
            .projects-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .about-grid {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 640px) {
            nav {
                display: none;
                position: absolute;
                top: 60px;
                right: 28px;
                background: var(--panel);
                padding: 16px;
                border-radius: var(--radius);
                flex-direction: column;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            nav.active {
                display: flex;
            }
            .burger {
                display: block;
            }
            h1 {
                font-size: 28px;
            }
            .projects-grid {
                grid-template-columns: 1fr;
            }
            .row {
                flex-direction: column;
            }
            .resume-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            footer {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
        
        /* Resume Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
            overflow-y: auto;
            padding: 20px;
        }
        .modal-content {
            background: var(--panel);
            max-width: 800px;
            margin: 40px auto;
            border-radius: var(--radius);
            padding: 30px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: var(--muted);
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s;
        }
        .close-modal:hover {
            color: var(--accent);
        }
        
        /* Project Detail Modal */
        .project-modal .modal-content {
            max-width: 900px;
        }
        .project-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 20px;
        }
        .project-image {
            border-radius: 12px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(255,107,92,0.05), rgba(0,0,0,0.05));
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 48px;
        }
        .project-info h3 {
            font-size: 24px;
            margin-bottom: 12px;
            color: var(--text);
        }
        .project-info p {
            color: var(--muted);
            margin-bottom: 16px;
        }
        .project-features {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }
        .project-features li {
            margin-bottom: 8px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .project-features li::before {
            content: '✓';
            color: var(--accent);
            font-weight: bold;
        }
        .project-links {
            display: flex;
            gap: 12px;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.8s ease forwards;
        }
        
        /* Print Styles for Resume */
        @media print {
            body * {
                visibility: hidden;
            }
            .print-resume, 
            .print-resume * {
                visibility: visible;
            }
            .print-resume {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: auto;
                background: white !important;
                color: black !important;
                margin: 0;
                padding: 20px;
                overflow: visible;
                font-family: Arial, sans-serif;
            }
            .no-print {
                display: none !important;
            }
            .resume-section h3 {
                color: #333 !important;
            }
            .resume-item h4 {
                color: #333 !important;
            }
            .skill-item {
                background: #f5f5f5 !important;
                color: #333 !important;
                border: 1px solid #ddd;
            }
            .btn {
                display: none !important;
            }
        }

        /* Timeline for resume */
        .timeline {
            position: relative;
            padding-left: 20px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(255,107,92,0.3);
        }
        
        /* Certificate badges */
        .certificates {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 12px;
        }
        .certificate {
            background: var(--glass);
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        .certificate i {
            color: var(--accent);
        }
    </style>
</head>
<body>
    <div class="wrap">
        <header>
            <a class="logo" href="#">Basharat Iqbal</a>
            <nav id="nav">
                <a href="#about">About</a>
                <a href="#resume">Resume</a>
                <a href="#projects">Projects</a>
                <a href="#contact">Contact</a>
                <button id="theme" aria-label="Toggle theme" title="Toggle theme">🌙</button>
            </nav>
            <button class="burger" id="burger" aria-label="Open menu">☰</button>
        </header>

        <main>
            <section class="hero">
                <div class="fade-in">
                    <p class="hello">Hello,</p>
                    <h1>I'm <span style="color:var(--accent)">Basharat Iqbal</span><br>Web Developer</h1>
                    <p class="lead">I design and build modern web applications — focused on performance, accessibility and pixel-perfect UI with 6 months of professional experience.</p>

                    <div class="cta">
                        <a class="btn btn-primary" href="#contact">Get in touch</a>
                        <a class="btn btn-outline" href="#" id="viewResumeBtn">View Resume</a>
                        <button class="btn btn-outline" id="printResumeDirectBtn">Print Resume</button>
                    </div>

                    <ul class="skills" aria-label="Technical Skills">
                        <li>HTML5</li>
                        <li>CSS3</li>
                        <li>JavaScript</li>
                        <li>Bootstrap</li>
                        <li>PHP</li>
                        <li>MySQL</li>
                        <li>Laravel</li>
                    </ul>
                </div>

                <aside class="card fade-in">
                    <div class="ring">
                        <!-- Profile Picture Section -->
                        <img class="profile" src="187.jpg" alt="Basharat Iqbal - Web Developer" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <!-- Fallback if image doesn't load -->
                        <div class="profile" style="background: linear-gradient(135deg, #ff6b5c, #4a90e2); display: none; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            BI
                        </div>
                    </div>
                    <div class="stats" role="list">
                        <div role="listitem"><strong>10+</strong><span>Projects</span></div>
                        <div role="listitem"><strong>6 mos</strong><span>Experience</span></div>
                        <div role="listitem"><strong>100%</strong><span>Dedication</span></div>
                    </div>
                </aside>
            </section>

            <section id="about">
                <h2>About me</h2>
                <p style="color:var(--muted)">I'm a passionate Web Developer specializing in frontend and backend development. With 6 months of professional experience, I enjoy solving problems and crafting interfaces that are both usable and beautiful.</p>
                <div class="about-grid">
                    <div>
                        <h3 style="color:var(--text); margin-bottom:12px;">What I Do</h3>
                        <ul class="about-list">
                            <li>Frontend Development (HTML, CSS, JavaScript)</li>
                            <li>Backend Development (PHP, MySQL)</li>
                            <li>Framework Implementation (Laravel, Bootstrap)</li>
                            <li>Responsive Web Design</li>
                            <li>Database Design & Management</li>
                        </ul>
                    </div>
                    <div>
                        <h3 style="color:var(--text); margin-bottom:12px;">My Approach</h3>
                        <p style="color:var(--muted)">I focus on clean code, fast load times and good UX. I'm passionate about learning new technologies and building maintainable systems that solve real-world problems.</p>
                        <p style="color:var(--muted); margin-top:10px;">Currently expanding my skills in web development while gaining practical experience in various projects.</p>
                    </div>
                </div>
            </section>

            <section id="resume">
                <h2>Resume</h2>
                <p style="color:var(--muted); margin-bottom:20px;">A summary of my education, experience and skills.</p>
                
                <div class="resume-container">
                    <div class="resume-header">
                        <div>
                            <h2 class="resume-name">Basharat Iqbal</h2>
                            <p class="resume-contact">
                                <i class="fas fa-phone"></i> 03200519750 | 
                                <i class="fas fa-map-marker-alt"></i> Gilgit, Pakistan |
                                <i class="fas fa-envelope"></i> basharat@example.com
                            </p>
                        </div>
                        <button class="btn btn-primary" id="printResumeBtn">Print Resume</button>
                    </div>
                    
                    <div class="resume-section">
                        <h3><i class="fas fa-user"></i> Professional Summary</h3>
                        <p style="color:var(--muted)">Web Developer with 6 months of experience in web development. Skilled in frontend technologies (HTML, CSS, JavaScript, Bootstrap) and backend development (PHP, MySQL, Laravel). Passionate about creating efficient, scalable web applications with clean code and excellent user experiences.</p>
                    </div>
                    
                    <div class="resume-section">
                        <h3><i class="fas fa-graduation-cap"></i> Education</h3>
                        <div class="timeline">
                            <div class="resume-item">
                                <h4>Web Development Certification</h4>
                                <p class="date"><i class="far fa-calendar"></i> 2023</p>
                                <p>Completed comprehensive web development course covering frontend and backend technologies.</p>
                            </div>
                            <div class="resume-item">
                                <h4>Software Engineering (In Progress)</h4>
                                <p class="date"><i class="far fa-calendar"></i> Currently Enrolled</p>
                                <p>Pursuing degree in Software Engineering with focus on web technologies and application development.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="resume-section">
                        <h3><i class="fas fa-briefcase"></i> Experience</h3>
                        <div class="timeline">
                            <div class="resume-item">
                                <h4>Web Developer</h4>
                                <p class="date"><i class="far fa-calendar"></i> 6 Months Experience</p>
                                <p>Developed and maintained web applications using HTML, CSS, JavaScript, PHP and MySQL. Implemented responsive designs and collaborated on Laravel-based projects.</p>
                            </div>
                            <div class="resume-item">
                                <h4>Freelance Developer</h4>
                                <p class="date"><i class="far fa-calendar"></i> 2023 - Present</p>
                                <p>Worked with various clients to create custom web solutions, from simple landing pages to complex web applications.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="resume-section">
                        <h3><i class="fas fa-tools"></i> Technical Skills</h3>
                        <div class="skills-grid">
                            <div class="skill-item">
                                <i class="fab fa-html5 skill-icon"></i>
                                <span>HTML5</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 95%"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <i class="fab fa-css3-alt skill-icon"></i>
                                <span>CSS3</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 90%"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <i class="fab fa-js skill-icon"></i>
                                <span>JavaScript</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 85%"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <i class="fab fa-bootstrap skill-icon"></i>
                                <span>Bootstrap</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 88%"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <i class="fab fa-php skill-icon"></i>
                                <span>PHP</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 80%"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <i class="fas fa-database skill-icon"></i>
                                <span>MySQL</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 82%"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <i class="fab fa-laravel skill-icon"></i>
                                <span>Laravel</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 75%"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <i class="fab fa-git skill-icon"></i>
                                <span>Git</span>
                                <div class="skill-level">
                                    <div class="skill-progress" style="width: 78%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="resume-section">
                        <h3><i class="fas fa-award"></i> Certificates</h3>
                        <div class="certificates">
                            <div class="certificate">
                                <i class="fas fa-certificate"></i>
                                <span>Web Development Certification</span>
                            </div>
                            <div class="certificate">
                                <i class="fas fa-certificate"></i>
                                <span>Laravel Framework Course</span>
                            </div>
                            <div class="certificate">
                                <i class="fas fa-certificate"></i>
                                <span>Frontend Development</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="projects">
                <h2>Projects</h2>
                <p style="color:var(--muted); margin-bottom:20px;">Some of my recent work and personal projects. Click on any project to view details.</p>
                <div class="projects-grid">
                    <article class="project" data-project="1">
                        <div class="thumb">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>E-commerce Website</h3>
                        <p style="color:var(--muted)">Full-stack e-commerce solution with product catalog, shopping cart, and user authentication.</p>
                        <div class="project-tags">
                            <span class="project-tag">Laravel</span>
                            <span class="project-tag">MySQL</span>
                            <span class="project-tag">Bootstrap</span>
                        </div>
                    </article>

                    <article class="project" data-project="2">
                        <div class="thumb">
                            <i class="fas fa-blog"></i>
                        </div>
                        <h3>Portfolio Website</h3>
                        <p style="color:var(--muted)">Responsive portfolio website with modern design, smooth animations, and contact form.</p>
                        <div class="project-tags">
                            <span class="project-tag">HTML/CSS</span>
                            <span class="project-tag">JavaScript</span>
                            <span class="project-tag">PHP</span>
                        </div>
                    </article>

                    <article class="project" data-project="3">
                        <div class="thumb">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Task Management App</h3>
                        <p style="color:var(--muted)">Web-based task management application with drag-and-drop functionality.</p>
                        <div class="project-tags">
                            <span class="project-tag">JavaScript</span>
                            <span class="project-tag">PHP</span>
                            <span class="project-tag">MySQL</span>
                        </div>
                    </article>
                </div>
            </section>

            <section id="contact">
                <h2>Contact</h2>
                <p style="color:var(--muted); margin-bottom:20px;">Interested in working together? Get in touch!</p>
                <form id="contactForm" method="POST" aria-label="Contact form">
                    <div class="row">
                        <input type="text" name="name" placeholder="Your name" required>
                        <input type="email" name="email" placeholder="Your email" required>
                    </div>
                    <textarea name="message" rows="5" placeholder="Tell me about your project" required></textarea>
                    <div style="display:flex;gap:12px;align-items:center">
                        <button class="btn btn-primary" type="submit">Send message</button>
                        <div id="formMsg" class="form-msg" aria-live="polite"></div>
                    </div>
                </form>
            </section>
        </main>

        <footer>
            <small>© <span id="year"></span> Basharat Iqbal — Built with ♥</small>
            <div class="social-links">
                <a href="#" aria-label="GitHub"><i class="fab fa-github"></i> GitHub</a> • 
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i> LinkedIn</a> • 
                <a href="#" aria-label="Behance"><i class="fab fa-behance"></i> Behance</a>
            </div>
        </footer>
    </div>

    <!-- Resume Modal -->
    <div class="modal" id="resumeModal">
        <div class="modal-content">
            <button class="close-modal" id="closeModal">&times;</button>
            <div class="resume-header">
                <div>
                    <h2 class="resume-name">Basharat Iqbal</h2>
                    <p class="resume-contact">
                        <i class="fas fa-phone"></i> 03200519750 | 
                        <i class="fas fa-map-marker-alt"></i> Gilgit, Pakistan |
                        <i class="fas fa-envelope"></i> basharat@example.com
                    </p>
                </div>
                <button class="btn btn-primary" id="printModalResumeBtn">Print Resume</button>
            </div>
            
            <div class="resume-section">
                <h3><i class="fas fa-user"></i> Professional Summary</h3>
                <p style="color:var(--muted)">Web Developer with 6 months of experience in web development. Skilled in frontend technologies (HTML, CSS, JavaScript, Bootstrap) and backend development (PHP, MySQL, Laravel). Passionate about creating efficient, scalable web applications with clean code and excellent user experiences.</p>
            </div>
            
            <div class="resume-section">
                <h3><i class="fas fa-graduation-cap"></i> Education</h3>
                <div class="timeline">
                    <div class="resume-item">
                        <h4>Web Development Certification</h4>
                        <p class="date"><i class="far fa-calendar"></i> 2023</p>
                        <p>Completed comprehensive web development course covering frontend and backend technologies.</p>
                    </div>
                    <div class="resume-item">
                        <h4>Software Engineering (In Progress)</h4>
                        <p class="date"><i class="far fa-calendar"></i> Currently Enrolled</p>
                        <p>Pursuing degree in Software Engineering with focus on web technologies and application development.</p>
                    </div>
                </div>
            </div>
            
            <div class="resume-section">
                <h3><i class="fas fa-briefcase"></i> Experience</h3>
                <div class="timeline">
                    <div class="resume-item">
                        <h4>Web Developer</h4>
                        <p class="date"><i class="far fa-calendar"></i> 6 Months Experience</p>
                        <p>Developed and maintained web applications using HTML, CSS, JavaScript, PHP and MySQL. Implemented responsive designs and collaborated on Laravel-based projects.</p>
                    </div>
                    <div class="resume-item">
                        <h4>Freelance Developer</h4>
                        <p class="date"><i class="far fa-calendar"></i> 2023 - Present</p>
                        <p>Worked with various clients to create custom web solutions, from simple landing pages to complex web applications.</p>
                    </div>
                </div>
            </div>
            
            <div class="resume-section">
                <h3><i class="fas fa-tools"></i> Technical Skills</h3>
                <div class="skills-grid">
                    <div class="skill-item">
                        <i class="fab fa-html5 skill-icon"></i>
                        <span>HTML5</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 95%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <i class="fab fa-css3-alt skill-icon"></i>
                        <span>CSS3</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 90%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <i class="fab fa-js skill-icon"></i>
                        <span>JavaScript</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <i class="fab fa-bootstrap skill-icon"></i>
                        <span>Bootstrap</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 88%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <i class="fab fa-php skill-icon"></i>
                        <span>PHP</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 80%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <i class="fas fa-database skill-icon"></i>
                        <span>MySQL</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 82%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <i class="fab fa-laravel skill-icon"></i>
                        <span>Laravel</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 75%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <i class="fab fa-git skill-icon"></i>
                        <span>Git</span>
                        <div class="skill-level">
                            <div class="skill-progress" style="width: 78%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="resume-section">
                <h3><i class="fas fa-award"></i> Certificates</h3>
                <div class="certificates">
                    <div class="certificate">
                        <i class="fas fa-certificate"></i>
                        <span>Web Development Certification</span>
                    </div>
                    <div class="certificate">
                        <i class="fas fa-certificate"></i>
                        <span>Laravel Framework Course</span>
                    </div>
                    <div class="certificate">
                        <i class="fas fa-certificate"></i>
                        <span>Frontend Development</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Detail Modal -->
    <div class="modal project-modal" id="projectModal">
        <div class="modal-content">
            <button class="close-modal" id="closeProjectModal">&times;</button>
            <div id="projectDetailContent">
                <!-- Project details will be loaded here dynamically -->
            </div>
        </div>
    </div>

    <!-- Hidden print resume -->
    <div class="print-resume" style="display: none;">
        <div class="resume-header">
            <div>
                <h2 class="resume-name">Basharat Iqbal</h2>
                <p class="resume-contact">
                    <i class="fas fa-phone"></i> 03200519750 | 
                    <i class="fas fa-map-marker-alt"></i> Gilgit, Pakistan |
                    <i class="fas fa-envelope"></i> basharat@example.com
                </p>
            </div>
        </div>
        
        <div class="resume-section">
            <h3><i class="fas fa-user"></i> Professional Summary</h3>
            <p>Web Developer with 6 months of experience in web development. Skilled in frontend technologies (HTML, CSS, JavaScript, Bootstrap) and backend development (PHP, MySQL, Laravel). Passionate about creating efficient, scalable web applications with clean code and excellent user experiences.</p>
        </div>
        
        <div class="resume-section">
            <h3><i class="fas fa-graduation-cap"></i> Education</h3>
            <div class="timeline">
                <div class="resume-item">
                    <h4>Web Development Certification</h4>
                    <p class="date"><i class="far fa-calendar"></i> 2023</p>
                    <p>Completed comprehensive web development course covering frontend and backend technologies.</p>
                </div>
                <div class="resume-item">
                    <h4>Software Engineering (In Progress)</h4>
                    <p class="date"><i class="far fa-calendar"></i> Currently Enrolled</p>
                    <p>Pursuing degree in Software Engineering with focus on web technologies and application development.</p>
                </div>
            </div>
        </div>
        
        <div class="resume-section">
            <h3><i class="fas fa-briefcase"></i> Experience</h3>
            <div class="timeline">
                <div class="resume-item">
                    <h4>Web Developer</h4>
                    <p class="date"><i class="far fa-calendar"></i> 6 Months Experience</p>
                    <p>Developed and maintained web applications using HTML, CSS, JavaScript, PHP and MySQL. Implemented responsive designs and collaborated on Laravel-based projects.</p>
                </div>
                <div class="resume-item">
                    <h4>Freelance Developer</h4>
                    <p class="date"><i class="far fa-calendar"></i> 2023 - Present</p>
                    <p>Worked with various clients to create custom web solutions, from simple landing pages to complex web applications.</p>
                </div>
            </div>
        </div>
        
        <div class="resume-section">
            <h3><i class="fas fa-tools"></i> Technical Skills</h3>
            <div class="skills-grid">
                <div class="skill-item">
                    <i class="fab fa-html5 skill-icon"></i>
                    <span>HTML5</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 95%"></div>
                    </div>
                </div>
                <div class="skill-item">
                    <i class="fab fa-css3-alt skill-icon"></i>
                    <span>CSS3</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 90%"></div>
                    </div>
                </div>
                <div class="skill-item">
                    <i class="fab fa-js skill-icon"></i>
                    <span>JavaScript</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 85%"></div>
                    </div>
                </div>
                <div class="skill-item">
                    <i class="fab fa-bootstrap skill-icon"></i>
                    <span>Bootstrap</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 88%"></div>
                    </div>
                </div>
                <div class="skill-item">
                    <i class="fab fa-php skill-icon"></i>
                    <span>PHP</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 80%"></div>
                    </div>
                </div>
                <div class="skill-item">
                    <i class="fas fa-database skill-icon"></i>
                    <span>MySQL</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 82%"></div>
                    </div>
                </div>
                <div class="skill-item">
                    <i class="fab fa-laravel skill-icon"></i>
                    <span>Laravel</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 75%"></div>
                    </div>
                </div>
                <div class="skill-item">
                    <i class="fab fa-git skill-icon"></i>
                    <span>Git</span>
                    <div class="skill-level">
                        <div class="skill-progress" style="width: 78%"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="resume-section">
            <h3><i class="fas fa-award"></i> Certificates</h3>
            <div class="certificates">
                <div class="certificate">
                    <i class="fas fa-certificate"></i>
                    <span>Web Development Certification</span>
                </div>
                <div class="certificate">
                    <i class="fas fa-certificate"></i>
                    <span>Laravel Framework Course</span>
                </div>
                <div class="certificate">
                    <i class="fas fa-certificate"></i>
                    <span>Frontend Development</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Project data
        const projects = {
            1: {
                title: "E-commerce Website",
                description: "A full-stack e-commerce solution built with Laravel framework. The platform includes product catalog, shopping cart, user authentication, payment integration, and admin dashboard for inventory management.",
                features: [
                    "User registration and authentication system",
                    "Product catalog with search and filtering",
                    "Shopping cart and checkout process",
                    "Payment gateway integration",
                    "Admin dashboard for product management",
                    "Order tracking and history",
                    "Responsive design for all devices"
                ],
                technologies: ["Laravel", "MySQL", "Bootstrap", "JavaScript", "Stripe API"],
                liveLink: "#",
                githubLink: "#",
                image: "fas fa-shopping-cart"
            },
            2: {
                title: "Portfolio Website",
                description: "A responsive portfolio website showcasing my projects and skills. Built with modern frontend technologies and featuring smooth animations, contact form, and project filtering.",
                features: [
                    "Fully responsive design",
                    "Smooth scroll animations",
                    "Project filtering by category",
                    "Contact form with validation",
                    "Dark/light mode toggle",
                    "Optimized for performance",
                    "SEO friendly structure"
                ],
                technologies: ["HTML5", "CSS3", "JavaScript", "PHP", "MySQL"],
                liveLink: "#",
                githubLink: "#",
                image: "fas fa-blog"
            },
            3: {
                title: "Task Management App",
                description: "A web-based task management application with drag-and-drop functionality, categories, priority levels, and deadline tracking. Helps users organize their workflow efficiently.",
                features: [
                    "Drag and drop task organization",
                    "Task categories and tags",
                    "Priority levels and due dates",
                    "Progress tracking",
                    "User authentication",
                    "Data export functionality",
                    "Real-time updates"
                ],
                technologies: ["JavaScript", "PHP", "MySQL", "HTML/CSS", "jQuery UI"],
                liveLink: "#",
                githubLink: "#",
                image: "fas fa-tasks"
            }
        };

        // Initialize the page
        (function(){
            // Set current year in footer
            document.getElementById('year').textContent = new Date().getFullYear();

            // Mobile menu toggle
            const burger = document.getElementById('burger');
            const nav = document.getElementById('nav');
            if (burger) {
                burger.addEventListener('click', () => {
                    nav.classList.toggle('active');
                });
            }

            // Theme toggle
            const themeBtn = document.getElementById('theme');
            const currentTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', currentTheme);
            themeBtn.textContent = currentTheme === 'dark' ? '🌙' : '🌞';
            
            themeBtn.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                themeBtn.textContent = newTheme === 'dark' ? '🌙' : '🌞';
            });

            // Contact form submission
            const form = document.getElementById('contactForm');
            const msg = document.getElementById('formMsg');
            form.addEventListener('submit', function(e){
                e.preventDefault();
                msg.textContent = 'Sending…';
                setTimeout(() => {
                    msg.textContent = 'Thanks — I will reply soon.';
                    form.reset();
                }, 850);
            });

            // Resume modal functionality
            const viewResumeBtn = document.getElementById('viewResumeBtn');
            const resumeModal = document.getElementById('resumeModal');
            const closeModal = document.getElementById('closeModal');
            const printResumeBtn = document.getElementById('printResumeBtn');
            const printModalResumeBtn = document.getElementById('printModalResumeBtn');
            const printResumeDirectBtn = document.getElementById('printResumeDirectBtn');

            viewResumeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                resumeModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });

            closeModal.addEventListener('click', () => {
                resumeModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });

            // Print resume from main page
            printResumeBtn.addEventListener('click', () => {
                window.print();
            });

            // Print resume from modal
            printModalResumeBtn.addEventListener('click', () => {
                window.print();
            });

            // Direct print without opening modal
            printResumeDirectBtn.addEventListener('click', () => {
                window.print();
            });

            // Close modal when clicking outside content
            window.addEventListener('click', (e) => {
                if (e.target === resumeModal) {
                    resumeModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
                if (e.target === projectModal) {
                    projectModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });

            // Project modal functionality
            const projectModal = document.getElementById('projectModal');
            const closeProjectModal = document.getElementById('closeProjectModal');
            const projectDetailContent = document.getElementById('projectDetailContent');
            
            // Add click event to all projects
            document.querySelectorAll('.project').forEach(project => {
                project.addEventListener('click', () => {
                    const projectId = project.getAttribute('data-project');
                    showProjectDetails(projectId);
                });
            });
            
            closeProjectModal.addEventListener('click', () => {
                projectModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
            
            // Function to show project details
            function showProjectDetails(projectId) {
                const project = projects[projectId];
                if (!project) return;
                
                projectDetailContent.innerHTML = `
                    <h2>${project.title}</h2>
                    <div class="project-detail">
                        <div class="project-image">
                            <i class="${project.image}"></i>
                        </div>
                        <div class="project-info">
                            <h3>Project Overview</h3>
                            <p>${project.description}</p>
                            
                            <h3>Key Features</h3>
                            <ul class="project-features">
                                ${project.features.map(feature => `<li>${feature}</li>`).join('')}
                            </ul>
                            
                            <h3>Technologies Used</h3>
                            <div class="project-tags">
                                ${project.technologies.map(tech => `<span class="project-tag">${tech}</span>`).join('')}
                            </div>
                            
                            <div class="project-links">
                                <a href="${project.liveLink}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Live Demo
                                </a>
                                <a href="${project.githubLink}" class="btn btn-outline" target="_blank">
                                    <i class="fab fa-github"></i> View Code
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                
                projectModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            // Add fade-in animation to elements when they come into view
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, observerOptions);

            // Observe sections for animation
            document.querySelectorAll('section').forEach(section => {
                observer.observe(section);
            });
        })();
    </script>
</body>
</html>