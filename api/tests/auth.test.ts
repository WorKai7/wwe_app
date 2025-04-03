import request from "supertest";
import { app } from "../src/index";
import { prismaMock } from "./jest.setup";

describe("POST /public/register", () => {
  it("should register a new user", async () => {
    const newUser = { id: 1, username: "John Doe", email: "john@example.com", password: "secretpassword" };
    prismaMock.user.create.mockResolvedValue(newUser);
    const response: any = await request(app)
      .post("/public/register")
      .send({ username: "John Doe", email: "john@example.com", password: "secretpassword" });
    expect(response.status).toBe(201);
    expect(response.body).toEqual(newUser);
  });
});

describe("POST /public/login", () => {
  it("should return 400 if credentials are invalid", async () => {
    prismaMock.user.findUnique.mockResolvedValue(null);
    const response: any = await request(app)
      .post("/public/login")
      .send({ email: "john@example.com", password: "wrongpassword" });
    expect(response.status).toBe(400);
    expect(response.body).toEqual({ error: "Entrez un email et un mot de passe" });
  });
});