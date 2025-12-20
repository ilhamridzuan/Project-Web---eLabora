import { Router } from "express";
import { registerPasien, login } from "./auth.controller.js";

const r = Router();
r.post("/register", registerPasien);
r.post("/login", login);
export default r;
