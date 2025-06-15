import Echo from "laravel-echo";
import Pusher from "pusher-js";

// Gán Pusher vào window
window.Pusher = Pusher;
// window.Pusher.logToConsole = true;

// Cấu hình Echo với các tùy chọn tối ưu
const echo = new Echo({
  broadcaster: "pusher",
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || "ap1",
  wsHost: import.meta.env.VITE_PUSHER_HOST,
  wsPort: import.meta.env.VITE_PUSHER_PORT || 443,
  wssPort: import.meta.env.VITE_PUSHER_PORT || 443,
  forceTLS: (import.meta.env.VITE_PUSHER_SCHEME || "https") === "https",
  encrypted: true,
  
  // Cấu hình kết nối
  enabledTransports: ["ws", "wss"],
  disableStats: false,
  
  // Cấu hình retry và timeout
  enableStats: false,
  activityTimeout: 120000, // 2 phút
  pongTimeout: 30000,      // 30 giây
  unavailableTimeout: 16000, // 16 giây
  
  // Auth endpoint nếu cần xác thực
  // authEndpoint: import.meta.env.VITE_APP_URL ? `${import.meta.env.VITE_APP_URL}/broadcasting/auth` : '/broadcasting/auth',
  
  // Headers cho auth nếu cần
  auth: {
    headers: {
      // 'Authorization': `Bearer ${token}`, // Thêm token nếu cần
    },
  },
  
  // Log để debug
  logToConsole: import.meta.env.DEV,
});

// Event handlers cho debug
if (import.meta.env.DEV) {
  echo.connector.pusher.connection.bind('connecting', () => {
    console.log('🔄 Echo: Đang kết nối...');
  });

  echo.connector.pusher.connection.bind('connected', () => {
    console.log('✅ Echo: Đã kết nối thành công');
  });

  echo.connector.pusher.connection.bind('disconnected', () => {
    console.log('❌ Echo: Đã ngắt kết nối');
  });

  echo.connector.pusher.connection.bind('error', (error) => {
    console.error('🚨 Echo Error:', error);
  });

  echo.connector.pusher.connection.bind('unavailable', () => {
    console.warn('⚠️ Echo: Kết nối không khả dụng');
  });

  echo.connector.pusher.connection.bind('failed', () => {
    console.error('💥 Echo: Kết nối thất bại');
  });
}

export default echo;