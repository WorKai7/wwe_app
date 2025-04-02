import express from "express";

import { logger } from "./middleware/logger";
import { verifyJWT } from "./middleware/auth";

import { Hello } from "./routes/hello";
import { login, register } from "./routes/auth";
import { getAllBelts, getBeltById } from "./routes/belts"
import { getAllCards, getCardById } from "./routes/cards";
import { getAllEvents, getEventById } from "./routes/events";
import { getAllLocations, getLocationById } from "./routes/locations";
import { getAllMatchTypes, getMatchTypeById } from "./routes/matchTypes";
import { getAllMatches, getMatchById } from "./routes/matches";
import { getAllPromotions, getPromotionById } from "./routes/promotions";
import { getAllTables, getTableById } from "./routes/tables";
import { getAllWrestlers, getWrestlerById } from "./routes/wrestlers";


const PORT = process.env.API_PORT || undefined;
if (!PORT) {
    console.error("ERROR: Port non défini");
    process.exit(1);
}

export const app = express();
app.use(express.json());

// MIDDLEWARES
app.use(logger);
app.use(verifyJWT);

// START
app.listen(PORT, () => {
    console.log(`LOG: Demarrage du serveur sur le port ${PORT}`);
});


// --------------------------------------------------------------------------------


// ROUTES

// Hello
app.get("/hello", Hello);

// Auth
app.post("/auth/login", login);
app.post("/auth/register", register);

// Belts
app.get("/belts", getAllBelts);
app.get("/belts/:id", getBeltById);

// Cards
app.get("/cards", getAllCards);
app.get("/cards/:id", getCardById);

// Events
app.get("/events", getAllEvents);
app.get("/events/:id", getEventById);

// Locations
app.get("/locations", getAllLocations);
app.get("/locations/:id", getLocationById);

// Match Types
app.get("/matchTypes", getAllMatchTypes);
app.get("/matchTypes/:id", getMatchTypeById);

// Matches
app.get("/matches", getAllMatches);
app.get("/matches/:id", getMatchById);

// Promotions
app.get("/promotions", getAllPromotions);
app.get("/promotions/:id", getPromotionById);

// Tables
app.get("/tables", getAllTables);
app.get("/tables/:id", getTableById);

// Wrestlers
app.get("/wrestlers", getAllWrestlers);
app.get("/wrestlers/:id", getWrestlerById);