import { registerPasienSchema, loginSchema } from "./auth.validators.js";
import { AuthService } from "./auth.service.js";

export async function registerPasien(req, res, next) {
  try {
    const { error, value } = registerPasienSchema.validate(req.body);
    if (error) return res.status(400).json({ message: error.message });

    const result = await AuthService.registerPasien(value);
    return res.status(201).json(result);
  } catch (e) {
    // ER_DUP_ENTRY akan ditangani error middleware -> 409
    next(e);
  }
}

export async function login(req, res, next) {
  try {
    const { error, value } = loginSchema.validate(req.body);
    if (error) return res.status(400).json({ message: error.message });

    const result = await AuthService.login(value);

    if (!result.ok) {
      return res.status(result.status).json({ message: result.message });
    }

    return res.json({ token: result.token, role: result.role });
  } catch (e) {
    next(e);
  }
}
