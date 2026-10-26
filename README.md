# shopwise-service-template

Template for Shopwise Laravel microservices. The `ping` example proves HTTP → transactional outbox → Kafka → idempotent consumer, traced end to end in Grafana.

Run it from `shopwise-platform`: `tilt up -- --only=ping`, then

```sh
curl -s -XPOST localhost:8100/api/pings -H 'Content-Type: application/json' -d '{"message":"hello"}'
curl -s localhost:8100/api/pings/<id>   # consumedAt is set once the consumer handled platform.pinged
```

Start a new service: use this repo as a GitHub template, then follow the `new-service` skill. Conventions: `AGENTS.md`.
