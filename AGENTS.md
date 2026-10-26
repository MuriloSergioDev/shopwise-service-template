# shopwise-service-template (service: `ping`)

GitHub template for every Shopwise Laravel microservice. Its own service, `ping`, is a working example of the
full path HTTP → outbox → Kafka → consumer; new services keep the structure and delete the `Ping*` classes
(`new-service` skill in the shopwise plugin).

## Service facts
- **Owns**: `pings` table (database `ping` on the shared local Postgres).
- **Publishes**: `platform.pinged` (schema `shopwise-contracts/schemas/events/platform/pinged.v1.json`).
- **Consumes**: `platform.pinged` (itself — demo only) via consumer `pinged`.
- **HTTP**: `POST /api/pings`, `GET /api/pings/{id}` — contract `shopwise-contracts/openapi/ping.yaml`. Public; real services put routes behind `auth.jwt`.
- **Local URL**: http://localhost:8100 (Tilt port-forward).

## Structure (applies to every service)
| Path | Role |
|---|---|
| `app/Http/Controllers/<Verb><Noun>Controller.php` | invokable, request → `toData()` → Action → Resource |
| `app/Http/Requests` | validation + `toData()` |
| `app/Data` | `final readonly` DTOs |
| `app/Actions` | one `handle()`; DB transaction + `Outbox::record` |
| `app/Http/Resources` | response shape = OpenAPI schema |
| `app/Messaging/Handlers` | `MessageHandler`s, mapped in `config/messaging.php` |
| `deploy/values.yaml` | Helm values: consumers, owned topics, env |
| `tests/ArchTest.php` | enforces the rules above — keep it green, extend it for new rules |

Shared runtime (outbox, relay, consumer, JWT, money) comes from `shopwise/laravel-kit`; event DTOs from `shopwise/contracts` (`Shopwise\Contracts\Events\...`). Both install from GitHub `dev-main`.

## Running things
There is no host PHP. Use the toolbox image or the running pod:
- Tests and gate: `sh scripts/php.sh vendor/bin/pest` · `docker run --rm -v "$(pwd -W):/app" -w /app shopwise-php:base composer check`
- Inside the cluster (real Postgres/Kafka): `kubectl exec deploy/ping-http -- php artisan <cmd>`
- Tests use in-memory SQLite locally and Postgres in CI (env vars override `phpunit.xml`); write SQL that works on both, or skip the test on SQLite with a reason.
- Octane runs in worker mode: no request state in singletons/static properties.

## Checks
`composer check` = Pint --test, Rector --dry-run, Larastan (max), Pest --parallel. CI runs the same plus a `prod` image build.
