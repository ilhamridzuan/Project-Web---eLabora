export const AuditRepository = {
  /**
   * detail will be stored as JSON in audit_log.detail
   */
  async insert(conn, { entity, entity_id, aksi, changed_by_akun_id, detail }) {
    await conn.query(
      `INSERT INTO audit_log (entity, entity_id, aksi, changed_by_akun_id, changed_at, detail)
       VALUES (?, ?, ?, ?, NOW(), ?)`
      , [
        entity,
        entity_id,
        aksi,
        changed_by_akun_id ?? null,
        detail ? JSON.stringify(detail) : null,
      ]
    );
  },
};
