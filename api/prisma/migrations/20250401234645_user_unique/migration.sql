-- CreateTable
CREATE TABLE "Promotions" (
    "id" SERIAL NOT NULL,
    "name" TEXT,

    CONSTRAINT "Promotions_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Tables" (
    "id" SERIAL NOT NULL,
    "html" TEXT,
    "url" TEXT,

    CONSTRAINT "Tables_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Cards" (
    "id" SERIAL NOT NULL,
    "table_id" INTEGER,
    "location_id" INTEGER,
    "promotion_id" INTEGER,
    "event_date" TIMESTAMP(3),
    "event_id" INTEGER,
    "url" TEXT,
    "info_html" TEXT,
    "match_html" TEXT,

    CONSTRAINT "Cards_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Locations" (
    "id" SERIAL NOT NULL,
    "name" TEXT,

    CONSTRAINT "Locations_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Events" (
    "id" SERIAL NOT NULL,
    "name" TEXT,

    CONSTRAINT "Events_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Matches" (
    "id" SERIAL NOT NULL,
    "card_id" INTEGER,
    "winner_id" TEXT,
    "win_type" TEXT,
    "loser_id" TEXT,
    "match_type_id" TEXT,
    "duration" TEXT,
    "title_id" TEXT,
    "title_change" INTEGER,

    CONSTRAINT "Matches_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Belts" (
    "id" SERIAL NOT NULL,
    "name" TEXT,

    CONSTRAINT "Belts_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Wrestlers" (
    "id" SERIAL NOT NULL,
    "name" TEXT,

    CONSTRAINT "Wrestlers_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "Match_Types" (
    "id" SERIAL NOT NULL,
    "name" TEXT,

    CONSTRAINT "Match_Types_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "users" (
    "id" SERIAL NOT NULL,
    "username" VARCHAR(255),
    "password" VARCHAR(255),

    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
);

-- CreateIndex
CREATE UNIQUE INDEX "users_username_key" ON "users"("username");
