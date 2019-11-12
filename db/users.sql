BEGIN TRANSACTION;
DROP TABLE IF EXISTS "users";
CREATE TABLE IF NOT EXISTS "users" (
	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	"username"	TEXT UNIQUE,
	"name"	TEXT,
	"password"	TEXT
);
INSERT INTO "users" VALUES (1,'fredrik','Fredrik Wassermeyer','$2y$10$pmT1EU9oARwwMlV9SeZQJu1sMU/ETxWpQDunhFV.ZRt4C0CVxiF5G');
INSERT INTO "users" VALUES (2,'admin','All Mighty Administrator','$2y$10$zq7Y5WoyhpDSiaPOJfwK7eDRqqPjufcob4jsXfYBCWdbdxqF/IzU.');
COMMIT;
