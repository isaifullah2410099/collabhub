CREATE DATABASE IF NOT EXISTS uiu_collabhub;
USE uiu_collabhub;

CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(60) NOT NULL,
    email VARCHAR(80) NOT NULL,
    department VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    security_question VARCHAR(150) NOT NULL,
    security_answer VARCHAR(255) NOT NULL,
    skills VARCHAR(255),
    bio VARCHAR(500)
);

CREATE TABLE IF NOT EXISTS projects (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(120) NOT NULL,
    project_type VARCHAR(40) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    skills_needed VARCHAR(255) NOT NULL,
    team_size INT NOT NULL,
    deadline DATE,
    status VARCHAR(20) DEFAULT 'Open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS applications (
    application_id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    applicant_id INT NOT NULL,
    proposal VARCHAR(700) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(project_id, applicant_id)
);

CREATE TABLE IF NOT EXISTS portfolio (
    portfolio_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(120) NOT NULL,
    description VARCHAR(700) NOT NULL,
    skills VARCHAR(255)
);

-- ---------------------------------------------------------
-- Demo users
-- Password for all three users: 123456
-- Security answer for all three users: blue
-- ---------------------------------------------------------

INSERT IGNORE INTO users
(user_id, student_id, name, email, department, password, security_question, security_answer, skills, bio)
VALUES
(1, '011223344', 'Rahim Ahmed', 'rahim@example.com', 'CSE',
 '$2y$12$b2EcerKmadKGqlxMnbG9BuormE/OAN.3bp7/TBPzkfTHYYs7KyxBG',
 'What is your favourite color?',
 '$2y$12$a.YhO3AQSWq.ObcNVMGP..HS7Ev9C/VYlC57LbtOclbmNVrZeK0WS',
 'PHP, MySQL, HTML, CSS',
 'CSE student interested in practical web applications and collaborative projects.'),

(2, '011223355', 'Sara Islam', 'sara@example.com', 'CSE',
 '$2y$12$b2EcerKmadKGqlxMnbG9BuormE/OAN.3bp7/TBPzkfTHYYs7KyxBG',
 'What is your favourite color?',
 '$2y$12$a.YhO3AQSWq.ObcNVMGP..HS7Ev9C/VYlC57LbtOclbmNVrZeK0WS',
 'PHP, Research, MySQL, Data Analysis',
 'Interested in research tools, databases and student-focused software projects.'),

(3, '011223366', 'Nabil Hasan', 'nabil@example.com', 'EEE',
 '$2y$12$b2EcerKmadKGqlxMnbG9BuormE/OAN.3bp7/TBPzkfTHYYs7KyxBG',
 'What is your favourite color?',
 '$2y$12$a.YhO3AQSWq.ObcNVMGP..HS7Ev9C/VYlC57LbtOclbmNVrZeK0WS',
 'HTML, CSS, JavaScript, UI Design',
 'EEE student who enjoys frontend development, interface design and campus projects.');

-- ---------------------------------------------------------
-- Demo projects
-- ---------------------------------------------------------

INSERT IGNORE INTO projects
(project_id, user_id, title, project_type, description, skills_needed, team_size, deadline, status)
VALUES
(1, 1, 'UIU Lost & Found Platform', 'Personal Project',
 'A practical campus application where UIU students can report lost items, search existing reports and help return items to their owners.',
 'PHP, MySQL, HTML, CSS', 3, '2026-12-15', 'Open'),

(2, 2, 'Student Research Survey Tool', 'Research',
 'A simple web application for collecting survey responses from university students and organizing the results for academic research.',
 'PHP, MySQL, Research, Data Analysis', 4, '2026-12-20', 'Open'),

(3, 3, 'Campus Event Management', 'Academic Project',
 'A lightweight system for showing campus events, keeping event information organized and managing student participation.',
 'HTML, CSS, JavaScript, PHP', 3, '2027-01-10', 'Open'),

(4, 1, 'Student Club Website Refresh', 'Freelance Gig',
 'A small redesign project for a UIU student club that needs a cleaner landing page and better presentation of club activities.',
 'HTML, CSS, JavaScript, UI Design', 2, '2026-12-28', 'Open');

-- ---------------------------------------------------------
-- Demo applications
-- ---------------------------------------------------------

INSERT IGNORE INTO applications
(application_id, project_id, applicant_id, proposal, status)
VALUES
(1, 1, 2, 'I can help with the database and PHP backend. I also have experience working with forms and MySQL.', 'Accepted'),
(2, 1, 3, 'I would like to work on the interface and responsive CSS for the project.', 'Pending'),
(3, 2, 1, 'I can help build the PHP forms and database connection for collecting survey responses.', 'Pending');

-- ---------------------------------------------------------
-- Demo portfolio items
-- ---------------------------------------------------------

INSERT IGNORE INTO portfolio
(portfolio_id, user_id, title, description, skills)
VALUES
(1, 1, 'Student Management System', 'A small PHP and MySQL website for storing and viewing student records.', 'PHP, MySQL, HTML'),
(2, 2, 'Research Data Form', 'A web form for collecting structured research responses and saving them in a database.', 'PHP, MySQL, Research'),
(3, 3, 'Club Landing Page', 'A responsive landing page concept for a student club.', 'HTML, CSS, JavaScript');
