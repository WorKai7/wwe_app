import request from "supertest";
import { app } from "../src/index";
import { prismaMock } from "./jest.setup";


const mockedMatch = {
    id: 1,
    event_id: 10,
    participant1: "John Cena",
    participant2: "The Rock",
    result: "John Cena wins",
    date: new Date("2025-08-15T00:00:00.000Z"),
    card_id: null,
    winner_id: null,
    win_type: null,
    loser_id: null,
    match_type_id: null,
    duration: null,
    title_id: null,
    title_change: null
};

describe("GET /matches/:id", () => {
    it("should return a 200 status and the match having the given id", async () => {
        prismaMock.match.findUnique.mockResolvedValue(mockedMatch);
        const response: any = await request(app).get("/matches/1").send();

        expect(response.status).toBe(200);
        expect(response.body).toEqual({
            ...mockedMatch,
            date: mockedMatch.date.toISOString()
        });
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).get("/matches/abc").send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });

    it("should return 404 if the match is not found", async () => {
        prismaMock.match.findUnique.mockResolvedValue(null);
        const response: any = await request(app).get("/matches/9999").send();

        expect(response.status).toBe(404);
        expect(response.body).toEqual({ error: "Ce match n'existe pas" });
    });
});

describe("GET /matches", () => {
    it("should return a list of matches", async () => {
        const mockedMatches = [
            mockedMatch,
            {
                id: 2,
                event_id: 11,
                participant1: "Edge",
                participant2: "Chris Jericho",
                result: "Edge wins",
                date: new Date("2025-08-16T00:00:00.000Z"),
                card_id: null,
                winner_id: null,
                win_type: null,
                loser_id: null,
                match_type_id: null,
                duration: null,
                title_id: null,
                title_change: null
            }
        ];
        prismaMock.match.findMany.mockResolvedValue(mockedMatches);
        const response: any = await request(app).get("/matches").send();

        expect(response.status).toBe(200);
        const expectedMatches = mockedMatches.map(match => ({
            ...match,
            date: match.date.toISOString()
        }));
        expect(response.body).toEqual(expectedMatches);
    });
});

describe("POST /matches", () => {
    it("should create a new match", async () => {
        const newMatch = {
            id: 3,
            event_id: 12,
            participant1: "Roman Reigns",
            participant2: "Seth Rollins",
            result: "Roman Reigns wins",
            date: new Date("2025-08-17T00:00:00.000Z"),
            card_id: null,
            winner_id: null,
            win_type: null,
            loser_id: null,
            match_type_id: null,
            duration: null,
            title_id: null,
            title_change: null
        };
        prismaMock.match.create.mockResolvedValue(newMatch);
        const response: any = await request(app)
            .post("/matches")
            .send({
                event_id: newMatch.event_id,
                participant1: newMatch.participant1,
                participant2: newMatch.participant2,
                result: newMatch.result,
                date: newMatch.date.toISOString() 
            });

        expect(response.status).toBe(201);
        expect(response.body).toEqual({
            ...newMatch,
            date: newMatch.date.toISOString()
        });
    });
});

describe("PUT /matches/:id", () => {
    it("should update an existing match", async () => {
        const updatedMatch = {
            ...mockedMatch,
            result: "The Rock wins"
        };
        prismaMock.match.update.mockResolvedValue(updatedMatch);
        const response: any = await request(app)
            .put("/matches/1")
            .send({ result: "The Rock wins" });

        expect(response.status).toBe(200);
        expect(response.body).toEqual({
            ...updatedMatch,
            date: updatedMatch.date.toISOString()
        });
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/matches/abc")
            .send({ result: "Test" });

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});

describe("DELETE /matches/:id", () => {
    it("should delete an existing match", async () => {
        prismaMock.match.delete.mockResolvedValue(mockedMatch);
        const response: any = await request(app)
            .delete("/matches/1")
            .send();

        expect(response.status).toBe(204);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .delete("/matches/abc")
            .send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});