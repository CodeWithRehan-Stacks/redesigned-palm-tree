import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export const themeUtils = {
  // Apply glassmorphism based on theme
  glass: (baseClasses: string = '') => {
    return cn(
      'backdrop-blur-md bg-white/70 border border-white/20',
      'dark:bg-gray-900/70 dark:border-white/10',
      baseClasses
    );
  },

  // Get theme-aware colors
  colors: {
    primary: 'text-blue-600 dark:text-blue-400',
    secondary: 'text-gray-600 dark:text-gray-400',
    background: 'bg-white dark:bg-gray-900',
    surface: 'bg-gray-50 dark:bg-gray-800',
    border: 'border-gray-200 dark:border-gray-700',
  },

  // Animation utilities
  animations: {
    slideInUp: 'animate-slide-in-up',
    shimmer: 'animate-shimmer',
    bounceSubtle: 'animate-bounce-subtle',
    fadeIn: 'fade-in',
  },

  // Responsive utilities
  responsive: {
    mobileOnly: 'block md:hidden',
    desktopOnly: 'hidden md:block',
    mobileFirst: 'flex flex-col md:flex-row',
  },
};