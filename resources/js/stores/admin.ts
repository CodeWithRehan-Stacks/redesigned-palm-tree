import { create } from 'zustand';
import { persist } from 'zustand/middleware';

interface AdminState {
  // Theme management
  theme: 'light' | 'dark' | 'auto';
  setTheme: (theme: 'light' | 'dark' | 'auto') => void;

  // Dashboard state
  activeDashboard: string;
  setActiveDashboard: (dashboard: string) => void;

  // Real-time metrics
  metrics: Record<string, any>;
  updateMetric: (key: string, value: any) => void;

  // UI state
  sidebarCollapsed: boolean;
  toggleSidebar: () => void;

  // Notifications
  notifications: Array<{
    id: string;
    type: 'success' | 'error' | 'warning' | 'info';
    title: string;
    message: string;
    timestamp: Date;
    read: boolean;
  }>;
  addNotification: (notification: Omit<AdminState['notifications'][0], 'id' | 'timestamp' | 'read'>) => void;
  markNotificationRead: (id: string) => void;
  clearNotifications: () => void;

  // Command palette
  commandPaletteOpen: boolean;
  setCommandPaletteOpen: (open: boolean) => void;

  // Recent activity
  recentActivity: Array<{
    id: string;
    type: string;
    title: string;
    description: string;
    timestamp: Date;
    user?: {
      id: number;
      name: string;
      avatar?: string;
    };
  }>;
  addActivity: (activity: Omit<AdminState['recentActivity'][0], 'id' | 'timestamp'>) => void;
}

export const useAdminStore = create<AdminState>()(
  persist(
    (set, get) => ({
      // Theme
      theme: 'auto',
      setTheme: (theme) => set({ theme }),

      // Dashboard
      activeDashboard: 'analytics',
      setActiveDashboard: (dashboard) => set({ activeDashboard: dashboard }),

      // Metrics
      metrics: {},
      updateMetric: (key, value) =>
        set((state) => ({
          metrics: { ...state.metrics, [key]: value }
        })),

      // UI
      sidebarCollapsed: false,
      toggleSidebar: () =>
        set((state) => ({ sidebarCollapsed: !state.sidebarCollapsed })),

      // Notifications
      notifications: [],
      addNotification: (notification) =>
        set((state) => ({
          notifications: [
            {
              ...notification,
              id: Date.now().toString(),
              timestamp: new Date(),
              read: false,
            },
            ...state.notifications,
          ].slice(0, 50), // Keep only last 50 notifications
        })),
      markNotificationRead: (id) =>
        set((state) => ({
          notifications: state.notifications.map((n) =>
            n.id === id ? { ...n, read: true } : n
          ),
        })),
      clearNotifications: () => set({ notifications: [] }),

      // Command palette
      commandPaletteOpen: false,
      setCommandPaletteOpen: (open) => set({ commandPaletteOpen: open }),

      // Recent activity
      recentActivity: [],
      addActivity: (activity) =>
        set((state) => ({
          recentActivity: [
            {
              ...activity,
              id: Date.now().toString(),
              timestamp: new Date(),
            },
            ...state.recentActivity,
          ].slice(0, 100), // Keep only last 100 activities
        })),
    }),
    {
      name: 'sharenote-admin-store',
      partialize: (state) => ({
        theme: state.theme,
        sidebarCollapsed: state.sidebarCollapsed,
        activeDashboard: state.activeDashboard,
      }),
    }
  )
);