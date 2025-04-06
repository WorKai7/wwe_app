import request from "supertest";
import { app } from "../index";
import { prismaMock } from "./jest.setup";


const mockedLocation = {
    id: 1,
    name: "Madison Square Garden"
};

describe("GET /locations/:id", () => {
    it("should return a 200 status and the location having the given id", async () => {
        prismaMock.location.findUnique.mockResolvedValue(mockedLocation);
        const response: any = await request(app).get("/locations/1").send();

        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedLocation);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app).get("/locations/abc").send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });

    it("should return 404 if the location is not found", async () => {
        prismaMock.location.findUnique.mockResolvedValue(null);
        const response: any = await request(app).get("/locations/9999").send();

        expect(response.status).toBe(404);
        expect(response.body).toEqual({ error: "Cette location n'existe pas" });
    });
});

describe("GET /locations", () => {
    it("should return a list of locations", async () => {
        const mockedLocations = [
            mockedLocation,
            { id: 2, name: "Staples Center" }
        ];
        prismaMock.location.findMany.mockResolvedValue(mockedLocations);
        const response: any = await request(app).get("/locations").send();

        expect(response.status).toBe(200);
        expect(response.body).toEqual(mockedLocations);
    });
});

describe("POST /locations", () => {
    it("should create a new location", async () => {
        const newLocation = { id: 3, name: "O2 Arena" };
        prismaMock.location.create.mockResolvedValue(newLocation);
        const response: any = await request(app)
            .post("/locations")
            .send({ name: newLocation.name });

        expect(response.status).toBe(201);
        expect(response.body).toEqual(newLocation);
    });

    it("should return 400 if the name is missing", async () => {
        const response: any = await request(app)
            .post("/locations")
            .send({});

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "Le champ 'name' est requis" });
    });
});

describe("PUT /locations/:id", () => {
    it("should update an existing location", async () => {
        const updatedLocation = { ...mockedLocation, name: "Madison Square Garden Updated" };
        prismaMock.location.update.mockResolvedValue(updatedLocation);
        const response: any = await request(app)
            .put("/locations/1")
            .send({ name: "Madison Square Garden Updated" });

        expect(response.status).toBe(200);
        expect(response.body).toEqual(updatedLocation);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .put("/locations/abc")
            .send({ name: "Name" });

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});

describe("DELETE /locations/:id", () => {
    it("should delete an existing location", async () => {
        prismaMock.location.delete.mockResolvedValue(mockedLocation);
        const response: any = await request(app)
            .delete("/locations/1")
            .send();

        expect(response.status).toBe(204);
    });

    it("should return 400 for an invalid id", async () => {
        const response: any = await request(app)
            .delete("/locations/abc")
            .send();

        expect(response.status).toBe(400);
        expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
    });
});