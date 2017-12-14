USE zahill;
DELIMITER //
CREATE PROCEDURE create_choice (choice_id VARCHAR(4), text VARCHAR(512), question_id INT, exam_name VARCHAR(20))
begin
    INSERT INTO Choices VALUES (choice_id, text, question_id, exam_name);
end //
