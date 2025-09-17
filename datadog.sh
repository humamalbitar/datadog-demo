#!/bin/bash

# Datadog Agent Management Script

case "$1" in
    start)
        echo "Starting Datadog agent..."
        docker-compose -f docker-compose.datadog.yml up -d
        echo "Datadog agent started successfully!"
        echo "StatsD: localhost:8125"
        echo "APM: localhost:8126" 
        echo "Dashboard: https://us5.datadoghq.com"
        ;;
    stop)
        echo "Stopping Datadog agent..."
        docker-compose -f docker-compose.datadog.yml down
        echo "Datadog agent stopped."
        ;;
    restart)
        echo "Restarting Datadog agent..."
        docker-compose -f docker-compose.datadog.yml down
        docker-compose -f docker-compose.datadog.yml up -d
        echo "Datadog agent restarted successfully!"
        ;;
    logs)
        echo "Showing Datadog agent logs..."
        docker-compose -f docker-compose.datadog.yml logs -f dd-agent
        ;;
    status)
        echo "Checking Datadog agent status..."
        docker-compose -f docker-compose.datadog.yml ps
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|logs|status}"
        echo ""
        echo "Commands:"
        echo "  start   - Start the Datadog agent"
        echo "  stop    - Stop the Datadog agent"
        echo "  restart - Restart the Datadog agent"
        echo "  logs    - View agent logs"
        echo "  status  - Check agent status"
        exit 1
        ;;
esac
