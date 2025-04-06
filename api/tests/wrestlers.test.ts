import request from "supertest";
import { app } from "../index";
import { prismaMock } from "./jest.setup";

const mockedWrestler = {
  id: 1,
  name: "John Cena",
  birthDate: new Date("1980-04-23T00:00:00.000Z"),
  height: 185,
  weight: 113,
  promotion: "WWE"
};

describe("GET /wrestlers/:id", () => {
  it("should return a 200 status and the wrestler having the given id", async () => {
    prismaMock.wrestler.findUnique.mockResolvedValue(mockedWrestler);
    const response: any = await request(app).get("/wrestlers/1").send();
    expect(response.status).toBe(200);
    expect(response.body).toEqual({
      ...mockedWrestler,
      birthDate: mockedWrestler.birthDate.toISOString()
    });
  });

  it("should return 400 for an invalid id", async () => {
    const response: any = await request(app).get("/wrestlers/abc").send();
    expect(response.status).toBe(400);
    expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
  });

  it("should return 404 if the wrestler is not found", async () => {
    prismaMock.wrestler.findUnique.mockResolvedValue(null);
    const response: any = await request(app).get("/wrestlers/9999").send();
    expect(response.status).toBe(404);
    expect(response.body).toEqual({ error: "Ce wrestler n'existe pas" });
  });
});

describe("GET /wrestlers", () => {
  it("should return a list of wrestlers", async () => {
    const mockedWrestlers = [
      mockedWrestler,
      {
        id: 2,
        name: "The Rock",
        birthDate: new Date("1972-05-07T00:00:00.000Z"),
        height: 196,
        weight: 118,
        promotion: "WWE"
      }
    ];
    prismaMock.wrestler.findMany.mockResolvedValue(mockedWrestlers);
    const response: any = await request(app).get("/wrestlers").send();
    expect(response.status).toBe(200);
    const expectedWrestlers = mockedWrestlers.map(wrestler => ({
      ...wrestler,
      birthDate: wrestler.birthDate.toISOString()
    }));
    expect(response.body).toEqual(expectedWrestlers);
  });
});

describe("POST /wrestlers", () => {
  it("should create a new wrestler", async () => {
    const newWrestler = {
      id: 3,
      name: "Stone Cold Steve Austin",
      birthDate: new Date("1964-12-18T00:00:00.000Z"),
      height: 188,
      weight: 99,
      promotion: "WWE"
    };
    prismaMock.wrestler.create.mockResolvedValue(newWrestler);
    const response: any = await request(app)
      .post("/wrestlers")
      .send({
        name: newWrestler.name,
        birthDate: newWrestler.birthDate.toISOString(),
        height: newWrestler.height,
        weight: newWrestler.weight,
        promotion: newWrestler.promotion
      });
    expect(response.status).toBe(201);
    expect(response.body).toEqual({
      ...newWrestler,
      birthDate: newWrestler.birthDate.toISOString()
    });
  });

  it("should return 400 if required fields are missing", async () => {
    const response: any = await request(app).post("/wrestlers").send({});
    expect(response.status).toBe(400);
    expect(response.body).toEqual({ error: "Le champ 'name' est requis" });
  });
});

describe("PUT /wrestlers/:id", () => {
  it("should update an existing wrestler", async () => {
    const updatedWrestler = { ...mockedWrestler, name: "John Cena Updated" };
    prismaMock.wrestler.update.mockResolvedValue(updatedWrestler);
    const response: any = await request(app)
      .put("/wrestlers/1")
      .send({ name: "John Cena Updated" });
    expect(response.status).toBe(200);
    expect(response.body).toEqual({
      ...updatedWrestler,
      birthDate: updatedWrestler.birthDate.toISOString()
    });
  });

  it("should return 400 for an invalid id", async () => {
    const response: any = await request(app)
      .put("/wrestlers/abc")
      .send({ name: "Test" });
    expect(response.status).toBe(400);
    expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
  });
});

describe("DELETE /wrestlers/:id", () => {
  it("should delete an existing wrestler", async () => {
    prismaMock.wrestler.delete.mockResolvedValue(mockedWrestler);
    const response: any = await request(app).delete("/wrestlers/1").send();
    expect(response.status).toBe(204);
  });

  it("should return 400 for an invalid id", async () => {
    const response: any = await request(app).delete("/wrestlers/abc").send();
    expect(response.status).toBe(400);
    expect(response.body).toEqual({ error: "L'id fourni n'est pas valide" });
  });
});