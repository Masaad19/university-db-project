CREATE DATABASE university_academic_support_system;


USE university_academic_support_system;
/*DDL*/
CREATE TABLE login ( login_id INT AUTO_INCREMENT PRIMARY KEY,
password VARCHAR(255) NOT NULL,
phone VARCHAR(20) UNIQUE,
role VARCHAR(20) NOT NULL, 
CONSTRAINT chk_login_role 
CHECK (role IN ('student', 'instructor', 'admin')) 

);

CREATE TABLE department ( dep_id INT AUTO_INCREMENT PRIMARY KEY, 
dep_name VARCHAR(100) NOT NULL UNIQUE 

);

CREATE TABLE instructor (
    instructor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    date_of_birth DATE,
    address VARCHAR(255),
    phone_number VARCHAR(20) UNIQUE,
    login_id INT UNIQUE,
    CONSTRAINT fk_instructor_login
        FOREIGN KEY (login_id) REFERENCES login(login_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE student (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20) UNIQUE,
    date_of_birth DATE,
    address VARCHAR(255),
    batch_number INT,
    dep_id INT,
    login_id INT UNIQUE,
    FOREIGN KEY (dep_id) REFERENCES department(dep_id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (login_id) REFERENCES login(login_id)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE course (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    credit_hours INT NOT NULL CHECK (credit_hours > 0),
    course_name VARCHAR(100) NOT NULL,
    dep_id INT,
    instructor_id INT,
    FOREIGN KEY (dep_id) REFERENCES department(dep_id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (instructor_id) REFERENCES instructor(instructor_id)
        ON DELETE SET NULL ON UPDATE CASCADE
);


CREATE TABLE question (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('open','answered','closed') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES student(student_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (course_id) REFERENCES course(course_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE answer (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    instructor_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES question(question_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (instructor_id) REFERENCES instructor(instructor_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE enrollment (
    student_id INT,
    course_id INT,
    rating INT,
    comment TEXT,
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES student(student_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (course_id) REFERENCES course(course_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE marks (
    student_id INT,
    course_id INT,
    exam_id INT,
    score DECIMAL(5,2) NOT NULL CHECK (score >= 0),
    date_recorded DATE,
    PRIMARY KEY (student_id, course_id, exam_id),
    FOREIGN KEY (student_id) REFERENCES student(student_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (course_id, exam_id)
        REFERENCES exam(course_id, exam_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE topic (
    topic_id INT,
    course_id INT,
    instructor_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (course_id, topic_id),
    CONSTRAINT fk_topic_course
        FOREIGN KEY (course_id) REFERENCES course(course_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_topic_instructor
        FOREIGN KEY (instructor_id) REFERENCES instructor(instructor_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE material (
    material_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    course_id INT,
    topic_id INT,
    upload_date DATE,
    CONSTRAINT fk_material_topic
        FOREIGN KEY (course_id, topic_id)
        REFERENCES topic(course_id, topic_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE exam (
    exam_id INT,
    course_id INT,
    topic_id INT NULL,
    title VARCHAR(100) NOT NULL,
    exam_date DATE,
    total_marks INT NOT NULL,
    exam_type VARCHAR(50),
    PRIMARY KEY (course_id, exam_id),
    CONSTRAINT chk_exam_total_marks
        CHECK (total_marks > 0),
    CONSTRAINT fk_exam_course
        FOREIGN KEY (course_id) REFERENCES course(course_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_exam_topic
        FOREIGN KEY (course_id, topic_id)
        REFERENCES topic(course_id, topic_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE task (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    topic_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    due_date DATE,
    CONSTRAINT fk_task_topic
        FOREIGN KEY (course_id, topic_id)
        REFERENCES topic(course_id, topic_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE support_material (
    support_material_id INT AUTO_INCREMENT PRIMARY KEY,
    material_id INT NOT NULL,
    course_id INT,
    topic_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    upload_date DATE,
    CONSTRAINT fk_support_material_material
        FOREIGN KEY (material_id) REFERENCES material(material_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_support_material_topic
        FOREIGN KEY (course_id, topic_id)
        REFERENCES topic(course_id, topic_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE favorite (
    favorite_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    saved_date DATE,
    support_material_id INT NOT NULL,
    CONSTRAINT uq_favorite UNIQUE (student_id, support_material_id),
    CONSTRAINT fk_favorite_student
        FOREIGN KEY (student_id) REFERENCES student(student_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_favorite_support_material
        FOREIGN KEY (support_material_id) REFERENCES support_material(support_material_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


/*insert data*/

INSERT INTO login (login_id, password, phone, role) VALUES
(1, 'pass1',  '0590000001', 'student'),
(2, 'pass2',  '0590000002', 'student'),
(3, 'pass3',  '0590000003', 'student'),
(4, 'pass4',  '0590000004', 'student'),
(5, 'pass5',  '0590000005', 'student'),
(6, 'pass6',  '0590000006', 'student'),
(7, 'pass7',  '0590000007', 'instructor'),
(8, 'pass8',  '0590000008', 'instructor'),
(9, 'pass9',  '0590000009', 'instructor'),
(10, 'pass10', '0590000010', 'instructor'),
(11, 'pass11', '0590000011', 'instructor');


INSERT INTO department (dep_id, dep_name) VALUES
(1, 'Dentistry'),
(2, 'Computer Engineering'),
(3, 'Computer Science'),
(4, 'Medicine'),
(5, 'Pharmacy');


INSERT INTO instructor (instructor_id, email, date_of_birth, address, phone_number, login_id) VALUES
(1, 'suhad.daraghmeh@univ.edu', '1985-03-10', 'Jenin', '0561000001', 7),
(2, 'maher.abubaker@univ.edu',  '1982-07-14', 'Nablus', '0561000002', 8),
(3, 'firas.shakaa@univ.edu',    '1980-11-22', 'Tulkarm', '0561000003', 9),
(4, 'majd.barham@univ.edu',     '1979-01-05', 'Ramallah', '0561000004', 10),
(5, 'lina.haddad@univ.edu',     '1988-09-18', 'Hebron', '0561000005', 11);


INSERT INTO course (course_id, credit_hours, course_name, dep_id, instructor_id) VALUES
(1, 3, 'Dental Anatomy',        1, 4),
(2, 4, 'Programming I',         2, 3),
(3, 3, 'Data Structures',       3, 1),
(4, 3, 'Algorithms',            3, 2),
(5, 3, 'Computer Networks',     2, 3),
(6, 3, 'Oral Surgery Basics',   1, 4),
(7, 3, 'Human Anatomy',         4, 5),
(8, 3, 'Pharmacology I',        5, 5),
(9, 2, 'Database Systems',      3, 1);


INSERT INTO student (student_id, name, email, phone_number, date_of_birth, address, batch_number, dep_id, login_id) VALUES
(12323333, 'Yomna', 'yomna@mail.com', '0591111111', '2006-03-23', 'Nablus',    2022, 2, 1),
(12323906, 'Masa',  'masa@mail.com',  '0592222222', '2005-08-19', 'Nablus',   2022, 2, 2),
(12340845, 'Zain',  'zain@mail.com',  '0593333333', '2005-09-20', 'Tulkarm',  2022, 2, 3),
(12340133, 'Mayar', 'mayar@mail.com', '0594444444', '2005-06-11', 'Ramallah', 2022, 1, 4),
(12441453, 'Sama',  'sama@mail.com',  '0595555555', '2006-10-09', 'Qalqilya', 2022, 1, 5),
(12340269, 'Lara',  'lara@mail.com',  '0596666666', '2005-12-03', 'Jenin',    2022, 1, 6);


INSERT INTO enrollment (student_id, course_id, rating, comment) VALUES
(12323333, 2, 5, 'Excellent'),
(12323906, 2, 4, 'Very good'),
(12340845, 5, 5, 'Great'),
(12340133, 1, 4, 'Very useful'),
(12441453, 1, 4, 'Good'),
(12340269, 6, 5, 'Excellent');


INSERT INTO topic (topic_id, course_id, instructor_id, title, description, created_at) VALUES
(1, 1, 4, 'Tooth Structure', 'Introduction to tooth structure and morphology', '2026-04-01 09:00:00'),
(1, 2, 3, 'Variables and Loops', 'Basic programming constructs in introductory coding', '2026-04-01 10:00:00'),
(1, 3, 1, 'Arrays and Linked Lists', 'Core linear data structures', '2026-04-02 09:00:00'),
(1, 4, 2, 'Algorithm Complexity', 'Big O notation and efficiency basics', '2026-04-02 10:00:00'),
(1, 5, 3, 'OSI Model', 'Layers of computer networking', '2026-04-03 09:00:00'),
(1, 6, 4, 'Tooth Extraction', 'Basic principles of extraction', '2026-04-03 10:00:00'),
(1, 7, 5, 'Upper Limb', 'Bones and muscles of upper limb', '2026-04-04 09:00:00'),
(1, 8, 5, 'Drug Absorption', 'Intro to pharmacokinetics', '2026-04-04 10:00:00'),
(1, 9, 1, 'Normalization', 'Database normalization and design', '2026-04-05 09:00:00');


INSERT INTO material (material_id, title, description, course_id, topic_id, upload_date) VALUES
(1, 'Tooth Structure PDF',      'Lecture notes for tooth structure',         1, 1, '2026-04-06'),
(2, 'Programming Slides',       'Slides about variables and loops',          2, 1, '2026-04-06'),
(3, 'Data Structures Notes',    'Notes about arrays and linked lists',       3, 1, '2026-04-07'),
(4, 'Complexity Handout',       'Handout for algorithm complexity',          4, 1, '2026-04-07'),
(5, 'OSI Model Slides',         'Networking slides for OSI model',           5, 1, '2026-04-08'),
(6, 'Extraction Guide',         'Guide for extraction basics',               6, 1, '2026-04-08'),
(7, 'Upper Limb Atlas',         'Atlas for upper limb anatomy',              7, 1, '2026-04-09'),
(8, 'Pharmacokinetics PDF',     'Drug absorption lecture notes',             8, 1, '2026-04-09'),
(9, 'Normalization Sheet',      'Database normalization summary',            9, 1, '2026-04-10');



INSERT INTO exam (exam_id, course_id, topic_id, title, exam_date, total_marks, exam_type) VALUES
(1, 1, 1, 'Dental Anatomy Midterm',   '2026-04-20', 100, 'mid'),
(1, 2, 1, 'Programming Quiz',         '2026-04-21', 100, 'quiz'),
(1, 3, 1, 'Data Structures Exam',     '2026-04-22', 100, 'mid'),
(1, 4, 1, 'Algorithms Midterm',       '2026-04-23', 100, 'mid'),
(1, 5, 1, 'Networks Quiz',            '2026-04-24', 100, 'quiz'),
(1, 6, 1, 'Oral Surgery Test',        '2026-04-25', 100, 'mid'),
(1, 7, 1, 'Human Anatomy Exam',       '2026-04-26', 100, 'mid'),
(1, 8, 1, 'Pharmacology Test',        '2026-04-27', 100, 'mid'),
(1, 9, 1, 'Database Systems Quiz',    '2026-04-28', 100, 'quiz');


INSERT INTO task (task_id, course_id, topic_id, title, description, due_date) VALUES
(1, 1, 1, 'Tooth Diagram Assignment', 'Draw and label the main tooth parts',         '2026-04-15'),
(2, 2, 1, 'Loop Practice',            'Write simple programs using loops',            '2026-04-16'),
(3, 3, 1, 'List Comparison Task',     'Compare arrays and linked lists',              '2026-04-17'),
(4, 4, 1, 'Big O Worksheet',          'Solve complexity classification questions',    '2026-04-18'),
(5, 5, 1, 'OSI Summary',              'Summarize OSI layers in a short report',       '2026-04-19'),
(6, 6, 1, 'Extraction Case',          'Prepare a short extraction case discussion',    '2026-04-20'),
(7, 7, 1, 'Upper Limb Labeling',      'Label bones of the upper limb',                '2026-04-21'),
(8, 8, 1, 'Absorption Report',        'Write a brief report on drug absorption',      '2026-04-22'),
(9, 9, 1, 'Normalization Exercise',   'Normalize the given unnormalized table',       '2026-04-23');


INSERT INTO support_material (support_material_id, material_id, course_id, topic_id, title, description, upload_date) VALUES
(1, 1, 1, 1, 'Tooth Video',          'Supplementary video about tooth structure',      '2026-04-11'),
(2, 2, 2, 1, 'Loop Examples PDF',    'Extra solved examples for loops',                '2026-04-11'),
(3, 3, 3, 1, 'List Animation',       'Animation explaining linked lists',              '2026-04-12'),
(4, 4, 4, 1, 'Complexity Examples',  'Additional examples on algorithm complexity',    '2026-04-12'),
(5, 5, 5, 1, 'OSI Diagram',          'Visual OSI model diagram',                       '2026-04-13'),
(6, 6, 6, 1, 'Extraction Video',     'Clinical video for extraction basics',           '2026-04-13'),
(7, 7, 7, 1, 'Atlas Images',         'Supportive anatomy atlas images',                '2026-04-14'),
(8, 8, 8, 1, 'Drug Absorption Chart','Extra chart about drug absorption factors',      '2026-04-14'),
(9, 9, 9, 1, 'Normalization Examples','Worked examples for normalization',             '2026-04-15');


INSERT INTO favorite (favorite_id, student_id, saved_date, support_material_id) VALUES
(1, 12323333, '2026-04-12', 2),
(2, 12323906, '2026-04-12', 9),
(3, 12340845, '2026-04-13', 5),
(4, 12340133, '2026-04-13', 1),
(5, 12441453, '2026-04-14', 6);


INSERT INTO question (question_id, student_id, course_id, title, content, created_at, status) VALUES
(1, 12323333, 2, 'Question about loops',       'Can you explain the difference between while and for loops?', '2026-04-12 11:00:00', 'open'),
(2, 12323906, 9, 'Normalization confusion',    'How do I convert a table to 3NF?',                             '2026-04-12 12:00:00', 'answered'),
(3, 12340845, 5, 'OSI layers',                 'Which layers are responsible for routing and transport?',     '2026-04-13 09:30:00', 'answered'),
(4, 12340133, 1, 'Tooth cusps question',       'How can I differentiate between main cusps clinically?',     '2026-04-13 10:00:00', 'closed'),
(5, 12441453, 6, 'Extraction instruments',     'What instruments are commonly used for simple extraction?',   '2026-04-14 08:45:00', 'open');


INSERT INTO answer (answer_id, question_id, instructor_id, content, created_at) VALUES
(1, 1, 3, 'A for loop is useful when the number of iterations is known, while while is better when the condition controls repetition.', '2026-04-12 13:00:00'),
(2, 2, 1, 'Start by removing repeating groups, then partial dependencies, then transitive dependencies to reach 3NF.',                  '2026-04-12 13:30:00'),
(3, 3, 3, 'Routing is mainly at the network layer, and reliable transport is handled by the transport layer.',                           '2026-04-13 11:00:00'),
(4, 4, 4, 'Main cusps are identified based on tooth type and anatomical landmarks explained in the lecture.',                            '2026-04-13 12:00:00'),
(5, 5, 4, 'Common instruments include elevators and extraction forceps depending on the tooth and case.',                               '2026-04-14 10:00:00');


INSERT INTO marks (student_id, course_id, exam_id, score, date_recorded) VALUES
(12340133, 1, 1, 88.00, '2026-04-21'),
(12441453, 1, 1, 84.00, '2026-04-21'),
(12340269, 6, 1, 91.00, '2026-04-26'),
(12323333, 2, 1, 93.00, '2026-04-22'),
(12323906, 9, 1, 87.00, '2026-04-29');


INSERT INTO enrollment (student_id, course_id, rating, comment)
VALUES


(12323333, 1, 5, 'Excellent'),
(12323333, 2, 5, 'Excellent'),
(12323333, 3, 5, 'Excellent'),
(12323333, 4, 5, 'Excellent'),
(12323333, 5, 5, 'Excellent'),

(12323906, 1, 4, 'Very good'),
(12323906, 2, 4, 'Very good'),
(12323906, 3, 4, 'Very good'),
(12323906, 4, 4, 'Very good'),
(12323906, 5, 4, 'Very good'),

(12340845, 1, 5, 'Great'),
(12340845, 2, 5, 'Great'),
(12340845, 3, 5, 'Great'),
(12340845, 4, 5, 'Great'),
(12340845, 5, 5, 'Great'),


(12340133, 6, 4, 'Very useful'),
(12340133, 7, 4, 'Very useful'),
(12340133, 8, 4, 'Very useful'),

(12340269, 6, 5, 'Excellent'),
(12340269, 7, 5, 'Excellent'),
(12340269, 8, 5, 'Excellent'),

(12441453, 6, 4, 'Good'),
(12441453, 7, 4, 'Good'),
(12441453, 8, 4, 'Good');

INSERT INTO login
(login_id, password, phone, role)
VALUES
(
12,
'123',
'0561000006',
'instructor'
); 

INSERT INTO instructor
(instructor_id, name, email, date_of_birth, address, phone_number, login_id)
VALUES
(
6,
'Bashar Tahaina',
'bashar.tahaina@univ.edu',
'1985-05-10',
'Nablus',
'0561000006',
12
);


INSERT INTO login (login_id, password, phone, role)
VALUES
(13, '123', '0561000013', 'instructor'),
(14, '123', '0561000014', 'instructor'),
(15, '123', '0561000015', 'instructor');

INSERT INTO instructor
(instructor_id, name, email, date_of_birth, address, phone_number, login_id)
VALUES

(
10,
'Ahmad Salem',
'ahmad.salem@univ.edu',
'1975-08-20',
'Nablus',
'0561000013',
13
),

(
11,
'Lina Khalil',
'lina.khalil@univ.edu',
'1982-03-15',
'Ramallah',
'0561000014',
14
),

(
12,
'Samer Odeh',
'samer.odeh@univ.edu',
'1978-11-10',
'Jenin',
'0561000015',
15
);



 /*SQL Queries*/

/* SQL Queries - DML Examples */

UPDATE department
SET dep_name = 'Dentistry'
WHERE dep_id = 3;

UPDATE student
SET dep_id = 3
WHERE student_id IN (12340133, 12340269, 12441453);

UPDATE course
SET instructor_id = 2
WHERE course_name = 'Database Systems';

UPDATE course
SET instructor_id = 6
WHERE course_name = 'Image Processing';

UPDATE topic
SET title = 'SQL Fundamentals',
description = 'Introduction to SQL and databases'
WHERE course_id = 2;

UPDATE topic
SET title = 'Image Filtering',
description = 'Basics of image enhancement'
WHERE course_id = 1;

DELETE FROM question
WHERE question_id = 4;

SELECT s.name, s.student_id, d.dep_name
FROM student s
JOIN department d ON s.dep_id = d.dep_id;

SELECT s.name, c.course_name
FROM enrollment e
JOIN student s ON e.student_id = s.student_id
JOIN course c ON e.course_id = c.course_id;

SELECT c.course_name, i.name AS instructor_name
FROM course c
JOIN instructor i ON c.instructor_id = i.instructor_id;

SELECT c.course_name, t.title AS topic
FROM topic t
JOIN course c ON t.course_id = c.course_id;

SELECT t.title AS topic, m.title AS material
FROM topic t
JOIN material m 
ON t.course_id = m.course_id AND t.topic_id = m.topic_id;

SELECT t.title AS topic, task.title AS task
FROM topic t
JOIN task 
ON t.course_id = task.course_id AND t.topic_id = task.topic_id;

SELECT c.course_name, e.title, e.exam_date
FROM exam e
JOIN course c ON e.course_id = c.course_id;

SELECT t.title AS topic, e.title AS exam
FROM exam e
JOIN topic t 
ON e.course_id = t.course_id AND e.topic_id = t.topic_id;

SELECT s.name, c.course_name, m.score
FROM marks m
JOIN student s ON m.student_id = s.student_id
JOIN course c ON m.course_id = c.course_id;

SELECT s.name, m.score
FROM marks m
JOIN student s ON m.student_id = s.student_id
WHERE m.score > 85;

SELECT d.dep_name, COUNT(*) AS total_students
FROM student s
JOIN department d ON s.dep_id = d.dep_id
GROUP BY d.dep_name;

SELECT i.name AS instructor_name, COUNT(c.course_id) AS total_courses
FROM instructor i
LEFT JOIN course c ON i.instructor_id = c.instructor_id
GROUP BY i.instructor_id, i.name;

SELECT course_id, MAX(score) AS highest_score
FROM marks
GROUP BY course_id;

SELECT course_id, MIN(score) AS lowest_score
FROM marks
GROUP BY course_id;

SELECT course_id, AVG(score) AS avg_score
FROM marks
GROUP BY course_id;

SELECT m.title AS material, sm.title AS support_material
FROM material m
JOIN support_material sm ON m.material_id = sm.material_id;

SELECT s.name, sm.title
FROM favorite f
JOIN student s ON f.student_id = s.student_id
JOIN support_material sm ON f.support_material_id = sm.support_material_id;

SELECT t.title, COUNT(m.material_id) AS total_materials
FROM topic t
LEFT JOIN material m 
ON t.course_id = m.course_id AND t.topic_id = m.topic_id
GROUP BY t.title;

SELECT s.name
FROM student s
LEFT JOIN enrollment e ON s.student_id = e.student_id
WHERE e.student_id IS NULL;

SELECT c.course_name
FROM course c
LEFT JOIN enrollment e ON c.course_id = e.course_id
WHERE e.course_id IS NULL;

SELECT t.title, COUNT(task.task_id) AS total_tasks
FROM topic t
LEFT JOIN task 
ON t.course_id = task.course_id AND t.topic_id = task.topic_id
GROUP BY t.title;

SELECT q.title, a.content
FROM question q
JOIN answer a ON q.question_id = a.question_id;

SELECT title, content
FROM question
WHERE status = 'open';

SELECT s.name, m.score
FROM marks m
JOIN student s ON m.student_id = s.student_id
ORDER BY m.score DESC;

SELECT course_id, COUNT(*) AS total_exams
FROM exam
GROUP BY course_id;

SELECT s.name
FROM student s
LEFT JOIN marks m ON s.student_id = m.student_id
WHERE m.student_id IS NULL;

SELECT s.name, d.dep_name, c.course_name, m.score
FROM student s
LEFT JOIN department d ON s.dep_id = d.dep_id
LEFT JOIN enrollment e ON s.student_id = e.student_id
LEFT JOIN course c ON e.course_id = c.course_id
LEFT JOIN marks m ON s.student_id = m.student_id;

SELECT c.course_name, COUNT(e.student_id) AS total_students
FROM course c
LEFT JOIN enrollment e ON c.course_id = e.course_id
GROUP BY c.course_name;

SELECT sm.title, COUNT(f.favorite_id) AS total_favorites
FROM support_material sm
LEFT JOIN favorite f ON sm.support_material_id = f.support_material_id
GROUP BY sm.title;

SELECT s.name
FROM student s
JOIN department d ON s.dep_id = d.dep_id
WHERE d.dep_name = 'Dentistry';
