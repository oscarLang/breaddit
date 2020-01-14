--
-- Creating a User table.
--



--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "acronym" TEXT UNIQUE NOT NULL,
    "email" TEXT UNIQUE NOT NULL,
    "gravatar" TEXT,
    "password" TEXT,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);
