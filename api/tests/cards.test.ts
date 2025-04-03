import request from "supertest";
import { app } from "../src/index";
import { prismaMock } from "./jest.setup";

// Définition des objets de test avec event_date de type Date
const mockedCard = {
    id: 1,
    table_id: 5,
    location_id: 3,
    promotion_id: 2,
    event_date: new Date("2025-04-01T00:00:00.000Z"),
    event_id: 10,
    url: "http://example.com/card/1",
    info_html: "<p>Infos</p>",
    match_html: "<p>Match</p>"
};

describe("GET /cards/:id", () => {
    it("should return a 200 status and the card having the given id", async () => {
        prismaMock.card.findUnique.mockResolvedValue(mockedCard);
        const response: any = await request(app).get("/cards/1").send();

        expect(response.status).toBe(200);
        // Conversion de event_date en chaîne ISO pour matcher la réponse
        expect(response.body).toEqual({
            ...mockedCard,
            event_date: mockedCard.event_date.toISOString()
        });
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).get("/cards/abc").send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });

    it("should return 404 if the card is not found", async () => {
        prismaMock.card.findUnique.mockResolvedValue(null);
        const response: any = await request(app).get("/cards/9999").send();

        expect(response.status).toBe(404);
        expect(response.body).toEqual({ error: "Cette card n'existe pas" });
    });
});

describe("GET /cards", () => {
    it("should return a list of cards", async () => {
        const mockedCards = [
            mockedCard,
            {
                id: 2,
                table_id: 6,
                location_id: 4,
                promotion_id: 3,
                event_date: new Date("2025-04-02T00:00:00.000Z"),
                event_id: 11,
                url: "http://example.com/card/2",
                info_html: "<p>Infos 2</p>",
                match_html: "<p>Match 2</p>"
            }
        ];
        prismaMock.card.findMany.mockResolvedValue(mockedCards);
        const response: any = await request(app).get("/cards").send();

        expect(response.status).toBe(200);
        // On convertit event_date de chaque card en chaîne ISO pour la comparaison
        const expectedCards = mockedCards.map(card => ({
            ...card,
            event_date: card.event_date.toISOString()
        }));
        expect(response.body).toEqual(expectedCards);
    });
});

describe("POST /cards", () => {
    it("should create a new card", async () => {
        const newCard = {
            id: 3,
            table_id: 7,
            location_id: 5,
            promotion_id: 4,
            event_date: new Date("2025-04-03T00:00:00.000Z"),
            event_id: 12,
            url: "http://example.com/card/3",
            info_html: "<p>Infos 3</p>",
            match_html: "<p>Match 3</p>"
        };
        prismaMock.card.create.mockResolvedValue(newCard);
        const response: any = await request(app)
            .post("/cards")
            .send({
                table_id: newCard.table_id,
                location_id: newCard.location_id,
                promotion_id: newCard.promotion_id,
                event_date: newCard.event_date.toISOString(), // envoi de la date au format ISO
                event_id: newCard.event_id,
                url: newCard.url,
                info_html: newCard.info_html,
                match_html: newCard.match_html
            });

        expect(response.status).toBe(201);
        expect(response.body).toEqual({
            ...newCard,
            event_date: newCard.event_date.toISOString()
        });
    });
});

describe("PUT /cards/:id", () => {
    it("should update an existing card", async () => {
        const updatedCard = {
            ...mockedCard,
            url: "http://example.com/updated"
        };
        prismaMock.card.update.mockResolvedValue(updatedCard);
        const response: any = await request(app)
            .put("/cards/1")
            .send({ url: "http://example.com/updated" });

        expect(response.status).toBe(200);
        expect(response.body).toEqual({
            ...updatedCard,
            event_date: updatedCard.event_date.toISOString()
        });
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/cards/abc")
            .send({ url: "http://example.com/updated" });

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});

describe("DELETE /cards/:id", () => {
    it("should delete an existing card", async () => {
        prismaMock.card.delete.mockResolvedValue(mockedCard);
        const response: any = await request(app)
            .delete("/cards/1")
            .send();

        expect(response.status).toBe(204);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .delete("/cards/abc")
            .send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});