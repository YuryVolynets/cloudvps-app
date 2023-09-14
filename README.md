## cloudvps-app

## Разворачивание проекта локально

1. Клонировать проект

   ```
   git clone git@github.com:YuryVolynets/cloudvps-app.git /path/to/folder
   ```

2. Скопировать файл окружения и заполнить его
   ```
   cp .env.example .env
   ```

3. Установить composer-пакеты

   ```
   composer install
   ```

4. Установить и собрать node-пакеты

   ```
   npm install
   npm run build
   ```

5. Если предполагается работа в Docker, собрать и запустить контейнеры
      ```
      sail up -d
      ```
