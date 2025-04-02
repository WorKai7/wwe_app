import express from "express";

import { logger } from "./middleware/logger";
import { verifyJWT } from "./middleware/auth";

import { Hello } from "./routes/hello";
import { login, register } from "./routes/auth";
import { getAllBelts, getBeltById } from "./routes/belts";


const PORT = 3000;

export const app = express();
app.use(express.json());

// MIDDLEWARES
app.use(logger);
app.use(verifyJWT);

// START
app.listen(PORT, () => {
    console.log(`LOG: Demarrage du serveur sur le port ${PORT}`);
});

// --------------------

// ROUTES

// Hello
app.get("/hello", Hello);

// Auth
app.post("/auth/login", login);
app.post("/auth/register", register);

// Belts
app.get("/belts", getAllBelts);
app.get("/belts/:id", getBeltById);