# File can be run to create all of the needed tables
USE zahill;
CREATE TABLE Student (
    id INT NOT NULL,
    name VARCHAR(30) NOT NULL,
    password VARCHAR(50) NOT NULL,
    major VARCHAR(20) NOT NULL,
    PRIMARY KEY(id));

CREATE TABLE Exam (
    name VARCHAR(20) NOT NULL,
    date_created DATE NOT NULL,
    total_points INT NOT NULL,
    PRIMARY KEY(name));

CREATE TABLE Questions (
    question_id INT NOT NULL,
    exam_name VARCHAR(20) NOT NULL,
    correct_choice VARCHAR(4),
    points INT NOT NULL,
    text VARCHAR(512) NOT NULL,
    PRIMARY KEY(question_id, exam_name),
    FOREIGN KEY (exam_name) REFERENCES Exam(name)
    ON UPDATE CASCADE
    ON DELETE CASCADE);

CREATE TABLE Choices (
    choice_id VARCHAR(4) NOT NULL,
    text VARCHAR(512) NOT NULL,
    question_id INT NOT NULL,
    exam_name VARCHAR(20) NOT NULL,
    PRIMARY KEY(choice_id, question_id, exam_name),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (exam_name) REFERENCES Exam(name)
    ON UPDATE CASCADE
    ON DELETE CASCADE);

CREATE TABLE Takes (
    student_id INT NOT NULL,
    exam_name VARCHAR(20) NOT NULL,
    grade INT,
    PRIMARY KEY (student_id, exam_name),
    FOREIGN KEY (student_id) REFERENCES Student(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (exam_name) REFERENCES Exam(name)
    ON UPDATE CASCADE
    ON DELETE CASCADE);

CREATE TABLE Answers (
    student_id INT NOT NULL,
    exam_name VARCHAR(20) NOT NULL,
    question_id INT NOT NULL,
    student_choice INT,
    score INT NOT NULL,
    PRIMARY KEY (student_id, exam_name, question_id),
    FOREIGN KEY (student_id) REFERENCES Student(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES Questions(question_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (exam_name) REFERENCES Exam(name)
    ON UPDATE CASCADE
    ON DELETE CASCADE);

