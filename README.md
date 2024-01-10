# test-softexpert
Test Dev Fullstack PHP


## Docker
```
docker build . -t test.back:1.0.0
docker run -p "8000:8000" -v "./:/app" --name test.back test.back:1.0.0
```

