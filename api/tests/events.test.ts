import request from "supertest";
import { app } from "../index";
import { prismaMock } from "./jest.setup";


const mockedEvent = {
    id: 1,
    name: "WWE SummerSlam 2025",
    date: new Date("2025-07-20T00:00:00.000Z"),
    location_id: 2,
    promotion_id: 1
};

describe("GET /events/:id", () => {
    it("should return a 200 status and the event having the given id", async () => {
        prismaMock.event.findUnique.mockResolvedValue(mockedEvent);
        const response: any = await request(app).get("/events/1").send();

        expect(response.status).toBe(200);
        expect(response.body).toEqual({
            ...mockedEvent,
            date: mockedEvent.date.toISOString()
        });
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).get("/events/abc").send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });

    it("should return 404 if the event is not found", async () => {
        prismaMock.event.findUnique.mockResolvedValue(null);
        const response: any = await request(app).get("/events/9999").send();

        expect(response.status).toBe(404);
        expect(response.body).toEqual({ error: "Cet event n'existe pas" });
    });
});

describe("GET /events", () => {
    it("should return a list of events", async () => {
        const mockedEvents = [
            mockedEvent,
            {
                id: 2,
                name: "WWE Royal Rumble 2025",
                date: new Date("2025-01-26T00:00:00.000Z"),
                location_id: 3,
                promotion_id: 1
            }
        ];
        prismaMock.event.findMany.mockResolvedValue(mockedEvents);
        const response: any = await request(app).get("/events").send();

        expect(response.status).toBe(200);
        const expectedEvents = mockedEvents.map(event => ({
            ...event,
            date: event.date.toISOString()
        }));
        expect(response.body).toEqual(expectedEvents);
    });
});

describe("POST /events", () => {
    it("should create a new event", async () => {
        const newEvent = {
            id: 3,
            name: "WWE Survivor Series 2025",
            date: new Date("2025-11-25T00:00:00.000Z"),
            location_id: 4,
            promotion_id: 2
        };
        prismaMock.event.create.mockResolvedValue(newEvent);
        const response: any = await request(app)
            .post("/events")
            .send({
                name: newEvent.name,
                date: newEvent.date.toISOString(),
                location_id: newEvent.location_id,
                promotion_id: newEvent.promotion_id
            });

        expect(response.status).toBe(201);
        expect(response.body).toEqual({
            ...newEvent,
            date: newEvent.date.toISOString()
        });
    });
});

describe("PUT /events/:id", () => {
    it("should update an existing event", async () => {
        const updatedEvent = {
            ...mockedEvent,
            name: "WWE SummerSlam Updated"
        };
        prismaMock.event.update.mockResolvedValue(updatedEvent);
        const response: any = await request(app)
            .put("/events/1")
            .send({ name: "WWE SummerSlam Updated" });

        expect(response.status).toBe(200);
        expect(response.body).toEqual({
            ...updatedEvent,
            date: updatedEvent.date.toISOString()
        });
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/events/abc")
            .send({ name: "Invalid" });

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});

describe("DELETE /events/:id", () => {
    it("should delete an existing event", async () => {
        prismaMock.event.delete.mockResolvedValue(mockedEvent);
        const response: any = await request(app)
            .delete("/events/1")
            .send();

        expect(response.status).toBe(204);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .delete("/events/abc")
            .send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});