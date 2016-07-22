DROP TABLE IF EXISTS "roko_auth_errors";
CREATE TABLE "roko_auth_errors" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "ip" text(32) NOT NULL,
  "errors" integer NOT NULL
);

CREATE UNIQUE INDEX "roko_auth_errors_ip" ON "roko_auth_errors" ("ip");