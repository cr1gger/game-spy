# Game spy

## Backend setup
```
Edit config/db.php

composer isntall
php yii migrate
php yii user/create - Create admin user
```

## Frontend setup
```
Set base API url src/use/Enum.js 
npm i
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

## Build android application

1. Install and configure Android studio
2. Build frontend `npm run build`
3. Sync front with Android Studio `npx cap sync`
4. Open `android` folder in Android Studio
5. Run build =)
