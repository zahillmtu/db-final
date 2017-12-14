USE zahill;
DELIMITER //
CREATE PROCEDURE create_question (question_id INT, exam_name VARCHAR(20), correct_choice VARCHAR(4), points INT, text VARCHAR(512))
begin
    INSERT INTO Questions VALUES (question_id, exam_name, correct_choice, points, text);
end //
