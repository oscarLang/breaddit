SELECT
            Question.content,
            Question.created,
            Question.title,
            Question.user_id,
            Tag.name as tag_name,
            QuestionToTag.id AS q_t_id
FROM QuestionToTag
LEFT JOIN Question
	ON Question.id = QuestionToTag.question_id
LEFT JOIN Tag
	ON Tag.id = QuestionToTag.tag_id
WHERE
	(QuestionToTag.id = 1)
;

SELECT
Question.content,
Question.created,
Question.title,
Question.user_id,
Tag.name as tag_name,
QuestionToTag.id AS q_t_id
FROM
QuestionToTag
LEFT JOIN Question ON Question.id = QuestionToTag.question_id
LEFT JOIN Tag ON Tag.id = QuestionToTag.tag_id
WHERE QuestionToTag.tag_id = 1;
