import { useAdminStore } from '../stores/admin';

export const useNotifications = () => {
  const store = useAdminStore();

  const notify = {
    success: (title: string, message: string) => {
      store.addNotification({
        type: 'success',
        title,
        message,
      });
    },
    error: (title: string, message: string) => {
      store.addNotification({
        type: 'error',
        title,
        message,
      });
    },
    warning: (title: string, message: string) => {
      store.addNotification({
        type: 'warning',
        title,
        message,
      });
    },
    info: (title: string, message: string) => {
      store.addNotification({
        type: 'info',
        title,
        message,
      });
    },
  };

  const markAsRead = (id: string) => {
    store.markNotificationRead(id);
  };

  const clearAll = () => {
    store.clearNotifications();
  };

  return {
    notifications: store.notifications,
    unreadCount: store.notifications.filter(n => !n.read).length,
    notify,
    markAsRead,
    clearAll,
  };
};