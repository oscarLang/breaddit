DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "content" TEXT,
    "user_id" INTEGER,
    "parent_comment_id" INTEGER,
    "question_id" INTEGER,
    FOREIGN KEY (user_id) REFERENCES User(id),
    FOREIGN KEY (question_id) REFERENCES Question(id)
);

DROP TABLE IF EXISTS QuestionToTag;
CREATE TABLE QuestionToTag (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "tag_id" INTEGER,
    "question_id" INTEGER,
    FOREIGN KEY (tag_id) REFERENCES Tag(id),
    FOREIGN KEY (question_id) REFERENCES Question(id)
);

DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "name" TEXT
);

DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "title" TEXT NOT NULL,
    "content" TEXT,
    "user_id" INTEGER,
    FOREIGN KEY (user_id) REFERENCES User(id)
);
