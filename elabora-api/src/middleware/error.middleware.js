export function notFound(req, res) {
  res.status(404).json({ message: "Route not found" });
}

export function errorHandler(err, req, res, next) {
  console.error(err);

  // duplikat unique key MySQL (username/email/nik)
  if (String(err?.code) === "ER_DUP_ENTRY") {
    return res.status(409).json({ message: "Data sudah digunakan (duplicate)." });
  }

  res.status(500).json({ message: "Internal server error" });
}