USE zahill;
DELIMITER //
CREATE PROCEDURE set_correct_choice (q_id INT, e_name VARCHAR(20), choice VARCHAR(4))
begin
    UPDATE Questions SET correct_choice = choice
    WHERE question_id = q_id AND exam_name = e_name;
end //
