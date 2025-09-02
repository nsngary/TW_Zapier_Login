/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./nuxt.config.{js,ts}",
    "./app.vue",
    // Laravel Blade 檔案
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/**/*.php"
  ],
  theme: {
    extend: {
      // TW_Zapier 指定色彩方案
      colors: {
        // 主色調
        primary: {
          50: '#fbfaf8',
          100: '#ece9df',
          200: '#ddd4ca',
          300: '#c7b8a8',
          400: '#b09a85',
          500: '#86735E', // 主色
          600: '#7a6654',
          700: '#665548',
          800: '#54463d',
          // 擴充品牌階梯，便於後續配色引用
          _scale: ['#ddd4ca','#c7b8a8','#b09a85','#86735E','#7a6654','#665548','#54463d'],
          900: '#463a33',
          
        },
        // 輔助色調
        accent: {
          red: '#C2474A',
          orange: '#C07F56',
          crimson: '#C23928',
          tan: '#D19872',
          pink: '#EC7687',
          brown: '#662D10',
          olive: '#644F29',
          gray: '#6C604D',
          amber: '#A86F4B',
          ball: '#bd743a'
        },
        // 中性色
        neutral: {
          50: '#fbfaf8',
          100: '#f5f5f4',
          200: '#e7e5e4',
          300: '#d6d3d1',
          400: '#a8a29e',
          500: '#78716c',
          600: '#57534e',
          700: '#44403c',
          800: '#292524',
          900: '#1c1917',
        },
        // HeaderNavigation 特定顏色
        header: {
          bg: '#fbfaf8',
          border: '#ece9df',
          'text-primary': '#201515',
          'text-secondary': '#413735',
          'text-muted': '#574e4c',
          'text-disabled': '#6f6765',
          'link-hover': '#503ebd',
          'link-focus': '#695be8',
          'button-bg': '#ece9df',
          'button-hover': '#f5f3eb',
          'dropdown-bg': '#fffdf9',
          'dropdown-overlay': '#2015151a',
          'dropdown-indicator': '#b09a85',
        }
      },
      // 字體配置 - 宋體為主
      fontFamily: {
        'sans': ['Songti TC', 'Songti SC', 'STSong', 'SimSun', 'NSimSun', 'FangSong', 'KaiTi', 'Microsoft YaHei', 'PingFang TC', 'PingFang SC', 'serif'],
        'display': ['Songti TC', 'Songti SC', 'STSong', 'SimSun', 'NSimSun', 'FangSong', 'KaiTi', 'Microsoft YaHei', 'PingFang TC', 'PingFang SC', 'serif'],
        'serif': ['Songti TC', 'Songti SC', 'STSong', 'SimSun', 'NSimSun', 'FangSong', 'KaiTi', 'Microsoft YaHei', 'PingFang TC', 'PingFang SC', 'serif'],
      },
      // 間距配置
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem',
      },
      // 行高 （ tailwind 內建 ）
      lineHeight: {
        'leading-none': '1',
        'leading-tight': '1.25',
        'leading-snug': '1.375',
        'leading-normal': '1.5',
      },
      // 動畫配置
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'fade-in-up': 'fadeInUp 0.6s ease-out',
        'fade-in-down': 'fadeInDown 0.6s ease-out',
        'slide-up': 'slideUp 0.5s ease-out',
        'slide-down': 'slideDown 0.5s ease-out',
        'slide-left': 'slideLeft 0.5s ease-out',
        'slide-right': 'slideRight 0.5s ease-out',
        'scale-in': 'scaleIn 0.3s ease-out',
        'scale-up': 'scaleUp 0.2s ease-out',
        'bounce-gentle': 'bounceGentle 2s infinite',
        'pulse-gentle': 'pulseGentle 2s infinite',
        'float': 'float 3s ease-in-out infinite',
        'glow': 'glow 2s ease-in-out infinite alternate',
        'shimmer': 'shimmer 2s linear infinite',
        'typewriter': 'typewriter 3s steps(40) 1s forwards',
        'gradient-x': 'gradientX 3s ease infinite',
        'gradient-y': 'gradientY 3s ease infinite',
        'spin-slow': 'spin 3s linear infinite',
        'ping-slow': 'ping 2s cubic-bezier(0, 0, 0.2, 1) infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(30px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeInDown: {
          '0%': { opacity: '0', transform: 'translateY(-30px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideLeft: {
          '0%': { transform: 'translateX(20px)', opacity: '0' },
          '100%': { transform: 'translateX(0)', opacity: '1' },
        },
        slideRight: {
          '0%': { transform: 'translateX(-20px)', opacity: '0' },
          '100%': { transform: 'translateX(0)', opacity: '1' },
        },
        scaleIn: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        scaleUp: {
          '0%': { transform: 'scale(1)' },
          '100%': { transform: 'scale(1.05)' },
        },
        bounceGentle: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-5px)' },
        },
        pulseGentle: {
          '0%, 100%': { opacity: '1' },
          '50%': { opacity: '0.8' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        glow: {
          '0%': { boxShadow: '0 0 5px rgba(134, 115, 94, 0.2)' },
          '100%': { boxShadow: '0 0 20px rgba(134, 115, 94, 0.6)' },
        },
        shimmer: {
          '0%': { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        typewriter: {
          '0%': { width: '0' },
          '100%': { width: '100%' },
        },
        gradientX: {
          '0%, 100%': { backgroundPosition: '0% 50%' },
          '50%': { backgroundPosition: '100% 50%' },
        },
        gradientY: {
          '0%, 100%': { backgroundPosition: '50% 0%' },
          '50%': { backgroundPosition: '50% 100%' },
        },
      },
      // 動畫持續時間 - 添加 HeaderNavigation 需要的持續時間
      transitionDuration: {
        '250': '250ms', // HeaderNavigation 使用
      },

      // Outline offset - 添加 HeaderNavigation 需要的 outline offset
      outlineOffset: {
        '0.5': '0.125rem', // 2px，HeaderNavigation 使用
      },

      // 斷點配置 - 添加 HeaderNavigation 特定斷點
      screens: {
        'xs': '475px',
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'desktop': '1071px', // HeaderNavigation 桌面版斷點
        'xl': '1280px',
        '2xl': '1536px',
      },
    },
  },
  plugins: [
    // 使用條件導入來避免模組載入錯誤
    ...(function() {
      try {
        return [
          require('@tailwindcss/typography'),
          require('@tailwindcss/forms'),
          require('@tailwindcss/aspect-ratio'),
        ]
      } catch (error) {
        console.warn('Tailwind CSS plugins not found, skipping...')
        return []
      }
    })(),
  ],
}
