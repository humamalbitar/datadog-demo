#  Laravel Task Management with Datadog Monitoring

A production-ready Laravel application showcasing comprehensive **Datadog integration** for monitoring, observability, and performance tracking. This project demonstrates best practices for implementing Application Performance Monitoring (APM), custom metrics, structured logging, and infrastructure monitoring in modern web applications.

##  Key Features

###  Task Management System
- **Complete CRUD Operations**: Create, read, update, and delete tasks with full validation
- **Rich Task Properties**: 
  - Title and detailed descriptions
  - Status tracking (pending → in_progress → completed)
  - Priority levels (low, medium, high)
  - Due date management
- **Smart Task Statistics**: Real-time API endpoint for dashboard metrics and analytics
- **Modern UI**: Clean, responsive interface built with Tailwind CSS
- **Efficient Pagination**: Optimized handling of large task datasets

###  Database Architecture
- **SQLite Database**: Zero-configuration, file-based database perfect for development and testing
- **Eloquent Models**: Advanced ORM with custom scopes and relationships
- **Factory & Seeders**: Automated sample data generation for testing and demos
- **Migration System**: Version-controlled database schema management

###  Frontend Experience  
- **Blade Templates**: Server-side rendering with reusable, maintainable components
- **Tailwind CSS**: Utility-first CSS framework for rapid, responsive design
- **Vite Build System**: Lightning-fast development with optimized production builds
- **Interactive Forms**: Real-time validation with user-friendly feedback

##  Advanced Datadog Integration

###  Application Performance Monitoring (APM)
- **Distributed Tracing**: End-to-end request lifecycle tracking across all components
- **Database Query Analysis**: Automatic Eloquent ORM query instrumentation and optimization insights
- **Error Tracking & Analytics**: Comprehensive exception capturing with contextual stack traces
- **Performance Profiling**: Response times, throughput analysis, and bottleneck identification

###  Custom Metrics & Analytics
- **Business Metrics**: Task creation rates, completion analytics, priority distributions
- **HTTP Performance**: Request/response metrics by route, method, and status code
- **User Behavior**: Page views, interaction patterns, and user journey tracking
- **System Health**: Application uptime, resource utilization, and service availability

###  Structured Logging & Correlation
- **Trace-Log Correlation**: Automatic linking between distributed traces and log entries
- **Rich Contextual Data**: User IDs, task IDs, request metadata, and business context
- **Centralized Log Management**: Automated collection via Datadog Agent with intelligent parsing
- **Security & Audit Trails**: Comprehensive logging for compliance and security monitoring

###  Infrastructure & Container Monitoring
- **Docker Container Metrics**: Resource usage, health checks, and container lifecycle tracking
- **System-Level Monitoring**: CPU, memory, disk I/O, and network performance
- **Custom Dashboards**: Pre-built visualizations for immediate insights
- **Intelligent Alerting**: Proactive notifications based on performance thresholds and anomalies

##  Technology Stack

### Backend Foundation
- **Laravel 11**: Modern PHP framework with advanced features and security
- **PHP 8.2+**: Latest language features including performance improvements
- **SQLite**: Serverless database with ACID compliance
- **Eloquent ORM**: Advanced database abstraction with relationship management

### Frontend Technologies
- **Blade Templating**: Laravel's powerful templating engine with component architecture
- **Tailwind CSS**: Utility-first framework for rapid, maintainable styling
- **Vite**: Next-generation build tool with hot module replacement
- **Alpine.js Ready**: Prepared for interactive JavaScript components

### Monitoring & DevOps
- **Datadog PHP SDK**: Official integration with full feature support
- **DogStatsD Client**: High-performance custom metrics collection
- **Datadog Agent**: Containerized agent for log and metric forwarding
- **Docker Compose**: Complete development environment orchestration

### Development Ecosystem
- **Pest PHP**: Modern, elegant testing framework
- **Laravel Pint**: Automated code style enforcement
- **Composer**: Advanced PHP dependency management
- **GitHub Integration**: Version control with automated workflows

##  Getting Started

### System Requirements
- **PHP**: 8.2 or higher with required extensions
- **Composer**: Latest version for dependency management
- **Docker & Docker Compose**: For Datadog Agent and optional containerization
- **Node.js & npm**: 18+ for frontend asset compilation

### 1. Project Setup
```bash
# Clone the repository
git clone https://github.com/humamalbitar/datadog-demo.git
cd datadog-demo

# Install PHP dependencies
composer install

# Install Node.js dependencies and build assets
npm install
npm run build

# Set up environment configuration
cp .env.example .env
php artisan key:generate
```

### 2. Database Configuration
```bash
# Create and migrate database
touch database/database.sqlite
php artisan migrate

# Generate sample data (optional)
php artisan db:seed
```

### 3. Application Launch
```bash
# Start the development server
php artisan serve

# Access your application
open http://localhost:8000
```

##  Complete Datadog Setup Guide

### Step 1: Create Your Datadog Account
1. **Sign Up**: Visit [datadoghq.com](https://www.datadoghq.com) and create your free account
2. **Select Region**: Choose your data center region (US, EU, etc.)
3. **Organization Setup**: Complete your organization profile and preferences

### Step 2: Obtain API Credentials
Navigate to **Organization Settings → API Keys** in your Datadog dashboard:

```bash
# Required credentials for integration
DD_API_KEY=your_datadog_api_key_here      # For sending metrics and logs
DD_APP_KEY=your_datadog_app_key_here      # For API access and dashboards
DD_SITE=us5.datadoghq.com                 # Your Datadog site URL
```

 **Security Note**: Keep these keys secure and never commit them to version control.

### Step 3: Configure Environment Variables
Update your `.env` file with Datadog configuration:

```bash
# Core Datadog Configuration
DD_API_KEY=your_api_key_here
DD_APP_KEY=your_app_key_here
DD_SITE=us5.datadoghq.com

# Service Identification
DD_SERVICE=datadog-demo
DD_ENV=local
DD_VERSION=1.0.0

# Datadog Agent Connection
DD_DOGSTATSD_HOST=localhost
DD_DOGSTATSD_PORT=8125
DD_TRACE_AGENT_URL=http://localhost:8126

# Feature Toggles
DD_TRACE_ENABLED=true
DD_LOGS_INJECTION=true
DD_APM_ENABLED=true
```

### Step 4: Install Datadog Agent

#### Option A: Docker Compose (Recommended for Development)
```bash
# Update docker-compose.datadog.yml with your API key
# Replace 'your_api_key_here' in the file with your actual API key

# Start the Datadog Agent
docker-compose -f docker-compose.datadog.yml up -d

# Verify agent is running
docker ps | grep dd-agent
docker logs dd-agent
```

#### Option B: Native Installation

**macOS:**
```bash
brew install datadog-agent

# Configure agent
sudo cp /opt/datadog-agent/etc/datadog.yaml.example /opt/datadog-agent/etc/datadog.yaml
sudo vim /opt/datadog-agent/etc/datadog.yaml
# Add your API key and site configuration

# Start agent
sudo launchctl load -w /Library/LaunchDaemons/com.datadoghq.agent.plist
```

**Ubuntu/Debian:**
```bash
DD_API_KEY=your_api_key DD_SITE="us5.datadoghq.com" bash -c "$(curl -L https://s3.amazonaws.com/dd-agent/scripts/install_script.sh)"

# Start agent
sudo systemctl start datadog-agent
sudo systemctl enable datadog-agent
```

**Windows:**
```powershell
# Download and run the installer from Datadog's website
# Follow the GUI installation wizard
# Configure API key during installation
```

### Step 5: Install PHP APM Extension
```bash
# Download and install the Datadog PHP extension
curl -LO https://github.com/DataDog/dd-trace-php/releases/latest/download/datadog-setup.php
php datadog-setup.php --php-bin=all

# Verify installation
php -m | grep ddtrace

# Expected output: ddtrace
```

### Step 6: Configure Log Collection
Create or update the Datadog Agent log configuration:

```bash
# Copy log configuration (for Docker setup, this is automatic)
cp datadog-logs.yaml /opt/datadog-agent/etc/conf.d/laravel.d/conf.yaml

# Restart agent to apply configuration
sudo systemctl restart datadog-agent
# OR for Docker:
docker-compose -f docker-compose.datadog.yml restart dd-agent
```

### Step 7: Verify Integration

#### Check Agent Status
```bash
# For Docker installation
docker exec dd-agent datadog-agent status

# For native installation
sudo datadog-agent status

# Look for these healthy indicators:
#  Agent: Running
#  PM Agent: Running on port 8126
#  DogStatsD: Running on port 8125
#  API Key: Valid
```

#### Generate Test Data
```bash
# Start your Laravel application
php artisan serve

# Create some test tasks to generate metrics
php artisan db:seed

# Visit the application and interact with it
open http://localhost:8000
```

#### Verify Data Flow in Datadog

1. **Metrics Verification**:
   - Navigate to **Metrics → Explorer** in Datadog
   - Search for `tasks.created` or `http.requests`
   - Should see data points within 1-2 minutes

2. **APM Traces**:
   - Go to **APM → Service Map**
   - Look for `datadog-demo` service
   - Click on service to see traces and performance data

3. **Log Collection**:
   - Navigate to **Logs → Live Tail**
   - Filter by `service:datadog-demo`
   - Should see application logs with trace correlation

### Step 8: Troubleshooting Common Issues

#### Issue: No Metrics Appearing
```bash
# Check if DogStatsD is receiving data
netstat -lu | grep 8125

# Test metrics manually
php artisan tinker
>>> app(\DataDog\DogStatsd::class)->increment('test.metric', 1);
>>> exit

# Check agent logs
docker logs dd-agent | grep -i error
```

#### Issue: PHP Extension Not Loading
```bash
# Check PHP configuration
php -i | grep datadog

# Verify extension path
php --ini

# Restart web server after installation
sudo systemctl restart nginx
# OR
sudo systemctl restart apache2
```

#### Issue: Agent Connection Problems
```bash
# Check network connectivity
curl -v http://localhost:8125

# Verify agent configuration
docker exec dd-agent cat /etc/datadog-agent/datadog.yaml

# Check firewall settings
sudo ufw status
```

##  Understanding Your Data

### Available Metrics
Once configured, your application will automatically send these metrics:

#### Task Management Metrics
```bash
tasks.page.views          # Page view tracking
tasks.page.load_time      # Page performance metrics
tasks.created             # Task creation events (tagged by priority)
tasks.total.count         # Current total task count
tasks.errors              # Error tracking by operation
```

#### HTTP Performance Metrics
```bash
http.requests             # Request counts by route/method/status
http.request.duration     # Response time histograms
http.errors               # Error rates by endpoint
```

### Dashboard Creation
1. **Navigate to Dashboards**: Go to Datadog → Dashboards → New Dashboard
2. **Add Widgets**:
   - **Timeseries**: `tasks.created` over time
   - **Query Value**: Current `tasks.total.count`
   - **Distribution**: `http.request.duration` percentiles
   - **Top List**: Most frequently accessed pages

### Alerting Setup
Create intelligent alerts for proactive monitoring:

```bash
# Example Alert Conditions:
- High Error Rate: http.errors > 10 errors/5min
- Slow Response: avg(http.request.duration) > 2 seconds
- Task Creation Spike: tasks.created > 50 tasks/minute
```

##  Advanced Configuration

### Custom Metrics Implementation
Add business-specific metrics throughout your application:

```php
// In your controllers or services
app(\DataDog\DogStatsd::class)->increment('user.login', 1, [
    'method' => 'social',
    'provider' => 'google'
]);

app(\DataDog\DogStatsd::class)->histogram('database.query.duration', $queryTime, [
    'table' => 'tasks',
    'operation' => 'select'
]);

app(\DataDog\DogStatsd::class)->gauge('active.users', $activeUserCount);
```

### Enhanced Logging
Leverage structured logging with Datadog correlation:

```php
Log::info('User action completed', [
    'user_id' => auth()->id(),
    'action' => 'task_creation',
    'task_id' => $task->id,
    'execution_time' => $executionTime,
    'metadata' => [
        'priority' => $task->priority,
        'due_date' => $task->due_date
    ]
]);
```

### Production Optimization
For production environments, consider these optimizations:

```bash
# Environment optimizations
DD_TRACE_SAMPLE_RATE=0.1          # Sample 10% of traces
DD_DOGSTATSD_BUFFER_SIZE=8192     # Increase buffer for high throughput
DD_LOGS_CONFIG_USE_HTTP=true      # Use HTTP for reliable log delivery

# Performance tuning
DD_TRACE_ANALYTICS_ENABLED=true   # Enable trace analytics
DD_PROFILING_ENABLED=true         # Enable continuous profiler
```

##  Project Architecture

### Application Structure
```
datadog-demo/
├── app/
│   ├── Http/Controllers/
│   │   └── TaskController.php        # Main controller with Datadog metrics
│   ├── Models/
│   │   ├── Task.php                  # Task model with scopes
│   │   └── User.php                  # User authentication model
│   ├── Providers/
│   │   ├── AppServiceProvider.php    # Core service bindings
│   │   └── DatadogServiceProvider.php # DogStatsD configuration
│   └── Services/                     # Business logic layer
├── config/
│   ├── datadog.php                   # Datadog configuration
│   ├── logging.php                   # Enhanced logging setup
│   └── database.php                  # Database configuration
├── database/
│   ├── migrations/                   # Database schema
│   ├── factories/                    # Model factories for testing
│   └── seeders/                      # Sample data generation
├── resources/
│   ├── views/tasks/                  # Task management UI
│   └── css/app.css                   # Tailwind CSS styles
├── datadog-logs.yaml                 # Log collection configuration
├── docker-compose.datadog.yml        # Datadog Agent setup
└── README.md                         # This comprehensive guide
```

### Key Integration Points

#### TaskController.php - Business Logic with Monitoring
```php
// Comprehensive metrics tracking
public function store(Request $request) {
    $startTime = microtime(true);
    
    try {
        $task = Task::create($validated);
        
        // Business metrics
        app(DogStatsd::class)->increment('tasks.created', 1, [
            'priority' => $task->priority,
            'status' => $task->status
        ]);
        
        // Performance metrics
        app(DogStatsd::class)->histogram('tasks.creation.duration', 
            microtime(true) - $startTime
        );
        
        Log::info('Task created successfully', [
            'task_id' => $task->id,
            'execution_time' => microtime(true) - $startTime
        ]);
        
    } catch (\Exception $e) {
        app(DogStatsd::class)->increment('tasks.errors', 1, [
            'operation' => 'create'
        ]);
        throw $e;
    }
}
```

#### DatadogServiceProvider.php - Service Configuration
```php
public function register() {
    $this->app->singleton(DogStatsd::class, function ($app) {
        return new DogStatsd([
            'host' => config('datadog.dogstatsd.host'),
            'port' => config('datadog.dogstatsd.port'),
            'socket_path' => null,
            'global_tags' => [
                'env' => config('app.env'),
                'service' => config('datadog.service_name'),
                'version' => config('datadog.version')
            ]
        ]);
    });
}
```

##  Available API Endpoints

### Task Management API
```bash
# List all tasks with pagination
GET /tasks
Content-Type: application/json

# Create new task
POST /tasks
Content-Type: application/json
{
    "title": "Sample Task",
    "description": "Task description",
    "priority": "high",
    "status": "pending",
    "due_date": "2025-12-31"
}

# Update existing task
PUT /tasks/{id}
Content-Type: application/json

# Delete task
DELETE /tasks/{id}

# Get task statistics
GET /api/tasks/stats
Response: {
    "total_tasks": 156,
    "completed_tasks": 89,
    "pending_tasks": 45,
    "high_priority_tasks": 22
}
```

### Monitoring & Health API
```bash
# Application health check
GET /health
Response: {
    "status": "healthy",
    "timestamp": "2025-09-17T10:30:00.000Z",
    "services": {
        "database": "connected",
        "datadog": "active"
    }
}

# Metrics endpoint (for external monitoring)
GET /api/metrics
Response: {
    "requests_per_minute": 45,
    "average_response_time": 0.234,
    "error_rate": 0.02
}
```

##  Testing & Quality Assurance

### Running Tests
```bash
# Run all tests with Pest
./vendor/bin/pest

# Run with coverage report
./vendor/bin/pest --coverage --coverage-html=coverage-report

# Run specific test suite
./vendor/bin/pest tests/Feature/TaskManagementTest.php

# Run tests with parallel execution
./vendor/bin/pest --parallel

# Run tests in specific environment
APP_ENV=testing ./vendor/bin/pest
```

### Code Quality Tools
```bash
# Fix code style with Laravel Pint
./vendor/bin/pint

# Check code style without fixing
./vendor/bin/pint --test

# Static analysis with PHPStan
./vendor/bin/phpstan analyse

# Check for security vulnerabilities
composer audit
```

### Performance Testing
```bash
# Generate load for Datadog testing
for i in {1..100}; do
    curl -s http://localhost:8000/tasks > /dev/null &
done

# Monitor metrics in real-time
watch -n 1 'docker exec dd-agent datadog-agent status | grep -A 5 "DogStatsD"'
```

##  Deployment Guide

### Production Environment Setup

#### 1. Environment Configuration
```bash
# Production .env settings
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=warning

# Datadog Production Settings
DD_ENV=production
DD_VERSION=1.2.3
DD_TRACE_SAMPLE_RATE=0.1          # Sample 10% for high traffic
DD_DOGSTATSD_BUFFER_SIZE=8192     # Increase buffer size
DD_LOGS_CONFIG_USE_HTTP=true      # Reliable log delivery
```

#### 2. Application Optimization
```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Build optimized frontend assets
npm run build
```

#### 3. Docker Production Setup
```yaml
# docker-compose.prod.yml
version: '3.8'
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile.prod
    environment:
      - DD_ENV=production
      - DD_VERSION=${APP_VERSION}
    deploy:
      resources:
        limits:
          memory: 512M
        reservations:
          memory: 256M

  dd-agent:
    image: gcr.io/datadoghq/agent:7
    environment:
      - DD_API_KEY=${DD_API_KEY}
      - DD_SITE=${DD_SITE}
      - DD_DOGSTATSD_NON_LOCAL_TRAFFIC=true
    deploy:
      resources:
        limits:
          memory: 256M
```

#### 4. CI/CD Integration
```yaml
# .github/workflows/deploy.yml
name: Deploy with Datadog
on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Run tests
        run: ./vendor/bin/pest
        
      - name: Deploy to production
        run: |
          # Deploy application
          # Start Datadog monitoring
          
      - name: Notify Datadog of deployment
        uses: DataDog/datadog-ci@v1
        with:
          api-key: ${{ secrets.DD_API_KEY }}
          service: datadog-demo
          env: production
```

### Monitoring Best Practices

#### Custom Dashboards Setup
1. **Application Performance Dashboard**:
   ```json
   {
     "widgets": [
       {
         "type": "timeseries",
         "title": "Request Throughput",
         "query": "sum:http.requests{service:datadog-demo}.as_count()"
       },
       {
         "type": "query_value", 
         "title": "Active Tasks",
         "query": "max:tasks.total.count{service:datadog-demo}"
       }
     ]
   }
   ```

2. **Business Metrics Dashboard**:
   - Task creation trends
   - Priority distribution
   - Completion rates by time period
   - User engagement metrics

#### Alerting Strategy
```bash
# Critical Alerts (PagerDuty/SMS)
- Application down: No requests for 5 minutes
- High error rate: >5% errors for 3 minutes
- Database connection failure

# Warning Alerts (Email/Slack)  
- Slow response time: >2 seconds average for 10 minutes
- High task creation: >100 tasks/hour
- Memory usage: >80% for 15 minutes

# Info Alerts (Slack)
- New deployment notifications
- Daily usage summaries
- Weekly performance reports
```

## � Troubleshooting Guide

### Common Issues and Solutions

#### 1. Metrics Not Appearing in Datadog
```bash
# Check agent connectivity
docker exec dd-agent datadog-agent status

# Test metrics manually
php artisan tinker
>>> app(\DataDog\DogStatsd::class)->increment('test.metric', 1);
>>> exit

# Verify network connectivity
telnet localhost 8125
nc -u localhost 8125

# Check agent logs
docker logs dd-agent | grep -i "dogstatsd\|error"
```

#### 2. APM Traces Missing
```bash
# Verify PHP extension
php -m | grep ddtrace

# Check trace agent
curl http://localhost:8126/info

# Enable debug mode
export DD_TRACE_DEBUG=true
php artisan serve

# Check trace submission
tail -f storage/logs/laravel.log | grep trace
```

#### 3. Log Collection Issues
```bash
# Check log configuration
docker exec dd-agent cat /etc/datadog-agent/conf.d/laravel.d/conf.yaml

# Verify log permissions
ls -la storage/logs/
chmod 644 storage/logs/laravel.log

# Test log forwarding
echo "Test log entry" >> storage/logs/laravel.log
```

#### 4. Performance Issues
```bash
# Monitor resource usage
docker stats dd-agent

# Check metric buffer
docker exec dd-agent datadog-agent status | grep -A 10 "DogStatsD"

# Optimize sampling rate
# Add to .env: DD_TRACE_SAMPLE_RATE=0.1
```

### Debug Mode Configuration
```bash
# Enable comprehensive debugging
DD_TRACE_DEBUG=true
DD_DOGSTATSD_DEBUG=true
DD_LOGS_CONFIG_LOG_LEVEL=debug
LOG_LEVEL=debug

# Monitor debug output
tail -f storage/logs/laravel.log
docker logs dd-agent --follow
```

## � Resources & Documentation

### Official Documentation
- [Datadog PHP Documentation](https://docs.datadoghq.com/tracing/setup_overview/setup/php/)
- [Laravel Documentation](https://laravel.com/docs)
- [DogStatsD Guide](https://docs.datadoghq.com/developers/dogstatsd/)
- [Datadog APM Documentation](https://docs.datadoghq.com/tracing/)

### Community Resources
- [Datadog Community Forum](https://community.datadoghq.com/)
- [Laravel Community](https://laravel.io/)
- [PHP Performance Monitoring Best Practices](https://docs.datadoghq.com/tracing/guide/)

### Useful Commands Reference
```bash
# Datadog Agent Commands
datadog-agent status                    # Full agent status
datadog-agent check <check_name>        # Run specific check
datadog-agent configcheck              # Validate configuration
datadog-agent flare                     # Generate support bundle

# Laravel Artisan Commands
php artisan route:list                  # List all routes
php artisan queue:work                  # Process background jobs  
php artisan migrate:status              # Migration status
php artisan config:clear                # Clear configuration cache

# Docker Commands
docker-compose logs -f dd-agent         # Follow agent logs
docker-compose restart dd-agent         # Restart agent
docker exec -it dd-agent bash           # Access agent container
```

##  Contributing

### Development Workflow
1. **Fork the Repository**: Create your own fork on GitHub
2. **Create Feature Branch**: `git checkout -b feature/your-feature-name`
3. **Follow Standards**: Use Laravel and PSR-12 coding standards
4. **Add Tests**: Write comprehensive tests for new features
5. **Update Documentation**: Include relevant documentation updates
6. **Submit Pull Request**: Create a detailed pull request

### Code Standards
```bash
# Run code quality checks before committing
./vendor/bin/pint                       # Fix code style
./vendor/bin/pest                       # Run tests
./vendor/bin/phpstan analyse            # Static analysis
composer audit                          # Security check
```

### Adding New Features with Monitoring
When adding new features, ensure you include:

1. **Custom Metrics**: Add relevant business metrics
2. **Structured Logging**: Include contextual logging
3. **Error Tracking**: Implement proper error handling
4. **Performance Monitoring**: Add timing metrics for critical operations
5. **Tests**: Include tests that verify monitoring functionality

##  License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## 🎯 Next Steps

After setting up this demo application:

1. **Explore Datadog Features**: Navigate through the Datadog dashboard to understand the wealth of monitoring data
2. **Create Custom Dashboards**: Build dashboards specific to your business needs
3. **Set Up Alerts**: Configure proactive monitoring for your most critical metrics
4. **Scale the Architecture**: Apply these patterns to your production applications
5. **Advanced Features**: Explore Datadog's advanced features like synthetic monitoring, security monitoring, and infrastructure monitoring

**Built by Humam Albitar with ❤️ using Laravel, PHP, and Datadog for comprehensive application monitoring**

---

*For questions, issues, or contributions, please visit our [GitHub repository](https://github.com/humamalbitar/datadog-demo) or contact the development team.*
