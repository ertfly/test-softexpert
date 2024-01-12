# Project Description
Test Dev Fullstack PHP

# Requirements
- Docker
- Docker Compose (version '2')

# Understanding the structure
```
.
+-- front (folder ReactJS frontend)
+-- back (folder backend PHP)
```

# Installation Instructions #
- Clone project
```
git clone git@github.com:ertfly/test-softexpert.git
```

# Access folder product
```
cd test-softexpert
```

# Copy samples files setting in folder "back"
```
cd back
cp sample.env .env
```

# Copy samples files setting in folder "front"
```
cd ..
cd front/
cp sample.env .env
```

> **_NOTA:_**  This commands are linux or unix.

# Back folder and copy docker-compose files samples
```
cd ..
cp docker-compose.sample.yml docker-compose.yml
```

# Build containers
```
docker-compose build
```

# Run containers
```
docker-compose up
```

> **_NOTA:_**  When vendor or node_modules error use zip files in folder back and front.