CREATE TABLE IF NOT EXISTS "Promotions" (
	"id" SERIAL PRIMARY KEY,
	"name" TEXT
);

CREATE TABLE IF NOT EXISTS "Tables" (
    "id" SERIAL PRIMARY KEY,
    "html" TEXT,
    "url" TEXT
);

CREATE TABLE IF NOT EXISTS "Cards" (
    "id" SERIAL PRIMARY KEY,
    "table_id" INTEGER,
    "location_id" INTEGER,
    "promotion_id" INTEGER,
    "event_date" TIMESTAMP,
    "event_id" INTEGER,
    "url" TEXT,
    "info_html" TEXT,
    "match_html" TEXT
);

CREATE TABLE IF NOT EXISTS "Locations" (
    "id" SERIAL PRIMARY KEY,
    "name" TEXT
);


CREATE TABLE IF NOT EXISTS "Events" (
    "id" SERIAL PRIMARY KEY,
    "name" TEXT
);

CREATE TABLE IF NOT EXISTS "Matches" (
    "id" SERIAL PRIMARY KEY,
    "card_id" INTEGER,
    "winner_id" TEXT,
    "win_type" TEXT,
    "loser_id" TEXT,
    "match_type_id" TEXT,
    "duration" TEXT,
    "title_id" TEXT,
    "title_change" INTEGER
);

CREATE TABLE IF NOT EXISTS "Belts" (
    "id" SERIAL PRIMARY KEY,
    "name" TEXT
);

CREATE TABLE IF NOT EXISTS "Wrestlers" (
    "id" SERIAL PRIMARY KEY,
    "name" TEXT
);

CREATE TABLE IF NOT EXISTS "Match_Types" (
    "id" SERIAL PRIMARY KEY,
    "name" TEXT
);

CREATE TABLE users (
    "id" SERIAL PRIMARY KEY,
    "username" VARCHAR(255),
    "password" VARCHAR(255)
);