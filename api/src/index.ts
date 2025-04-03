import express from "express";

import YAML from 'yamljs';
import swaggerUi from 'swagger-ui-express';

import { logger } from "./middleware/logger";
import { verifyJWT } from "./middleware/auth";

import { Hello } from "./routes/hello";
import { login, register } from "./routes/auth";
import { getAllBelts, getBeltById, createBelt, updateBelt, deleteBelt } from "./routes/belts";
import { getAllCards, getCardById, createCard, updateCard, deleteCard } from "./routes/cards";
import { getAllEvents, getEventById, createEvent, updateEvent, deleteEvent } from "./routes/events";
import { getAllLocations, getLocationById, createLocation, updateLocation, deleteLocation } from "./routes/locations";
import { getAllMatchTypes, getMatchTypeById, createMatchType, updateMatchType, deleteMatchType } from "./routes/matchTypes";
import { getAllMatches, getMatchById, createMatch, updateMatch, deleteMatch } from "./routes/matches";
import { getAllPromotions, getPromotionById, createPromotion, updatePromotion, deletePromotion } from "./routes/promotions";
import { getAllTables, getTableById, createTable, updateTable, deleteTable } from "./routes/tables";
import { getAllWrestlers, getWrestlerById, createWrestler, updateWrestler, deleteWrestler } from "./routes/wrestlers";


// INIT
const PORT = process.env.API_PORT || undefined;
if (!PORT) {
    console.error("ERROR: Port non défini");
    process.exit(1);
}
export const app = express();
app.use(express.json());

// ROUTERS
const publicRouter = express.Router();

const apiRouter = express.Router();
apiRouter.use(verifyJWT);

app.use("/public", publicRouter);
app.use("/", apiRouter);

// SWAGGER
const swaggerDocument = YAML.load("./src/swagger.yaml");
publicRouter.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerDocument));

// MIDDLEWARES
app.use(logger);

// START
export const server = app.listen(PORT, () => {
    console.log(`LOG: Demarrage du serveur sur le port ${PORT}`);
});

export function closeServer() {
    server.close();
}


// -------------------- ROUTES -------------------- //


// ---------- PUBLIC ---------- //

publicRouter.post("/login", login);
publicRouter.post("/register", register);


// ---------- API ---------- // 

// Hello
apiRouter.get("/hello", Hello);

// Belts
apiRouter.get("/belts", getAllBelts);
apiRouter.get("/belts/:id", getBeltById);
apiRouter.post("/belts", createBelt);
apiRouter.put("/belts/:id", updateBelt);
apiRouter.delete("/belts/:id", deleteBelt);

// Cards
apiRouter.get("/cards", getAllCards);
apiRouter.get("/cards/:id", getCardById);
apiRouter.post("/cards", createCard);
apiRouter.put("/cards/:id", updateCard);
apiRouter.delete("/cards/:id", deleteCard);

// Events
apiRouter.get("/events", getAllEvents);
apiRouter.get("/events/:id", getEventById);
apiRouter.post("/events", createEvent);
apiRouter.put("/events/:id", updateEvent);
apiRouter.delete("/events/:id", deleteEvent);

// Locations
apiRouter.get("/locations", getAllLocations);
apiRouter.get("/locations/:id", getLocationById);
apiRouter.post("/locations", createLocation);
apiRouter.put("/locations/:id", updateLocation);
apiRouter.delete("/locations/:id", deleteLocation);

// Match Types
apiRouter.get("/matchTypes", getAllMatchTypes);
apiRouter.get("/matchTypes/:id", getMatchTypeById);
apiRouter.post("/matchTypes", createMatchType);
apiRouter.put("/matchTypes/:id", updateMatchType);
apiRouter.delete("/matchTypes/:id", deleteMatchType);

// Matches
apiRouter.get("/matches", getAllMatches);
apiRouter.get("/matches/:id", getMatchById);
apiRouter.post("/matches", createMatch);
apiRouter.put("/matches/:id", updateMatch);
apiRouter.delete("/matches/:id", deleteMatch);

// Promotions
apiRouter.get("/promotions", getAllPromotions);
apiRouter.get("/promotions/:id", getPromotionById);
apiRouter.post("/promotions", createPromotion);
apiRouter.put("/promotions/:id", updatePromotion);
apiRouter.delete("/promotions/:id", deletePromotion);

// Tables
apiRouter.get("/tables", getAllTables);
apiRouter.get("/tables/:id", getTableById);
apiRouter.post("/tables", createTable);
apiRouter.put("/tables/:id", updateTable);
apiRouter.delete("/tables/:id", deleteTable);

// Wrestlers
apiRouter.get("/wrestlers", getAllWrestlers);
apiRouter.get("/wrestlers/:id", getWrestlerById);
apiRouter.post("/wrestlers", createWrestler);
apiRouter.put("/wrestlers/:id", updateWrestler);
apiRouter.delete("/wrestlers/:id", deleteWrestler);


// -------------------- START SUCESS -------------------- //
console.log("LOG: Serveur démarré sur le port " + PORT);