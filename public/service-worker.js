// Danh sách các file cần cache
const CACHE_NAME = "heart-daily-cache-v1";
const urlsToCache = [
    "/",
    "/manifest.json",
    "/css/style.css", // Thêm đường dẫn CSS/JS chính xác
    "/images/icons/LOGO.png",
];

// Sự kiện 'install' để cache file
self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log("Opened cache");
            return cache.addAll(urlsToCache);
        })
    );
});

// Sự kiện 'fetch' để phục vụ từ cache khi offline
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});

// Sự kiện 'activate' để xóa cache cũ
self.addEventListener("activate", event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames =>
            Promise.all(
                cacheNames.map(cacheName => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            )
        )
    );
});
