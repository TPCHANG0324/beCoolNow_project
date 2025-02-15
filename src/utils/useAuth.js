import { ref } from 'vue'
import { useRouter } from 'vue-router'

// console.log(import.meta.env.VITE_AJAX_URL);

export function useAuth() {
    const router = useRouter()
    const isAuthenticated = ref(false)
    const userEmail = ref('')
    const isLoading = ref(false)

    const checkAuth = async () => {
        isLoading.value = true
        try {
            // 環境路徑變數 , 輔導老師建議用這個方法 (.env.development, .env.production )
            // const base_url = import.meta.env.VITE_AJAX_URL
            // const res = await fetch(base_url + '/checkLogin.php', {
            //     // credentials: 'include'
            // });
            // const data = await res.json();
            // isAuthenticated.value = data.success
            // userEmail.value = data.success ? data.email : ''
            // localStorage.setItem('isLoggedIn', 'true');
            const is_login = localStorage.getItem('isLoggedIn');
            return is_login //返回登入狀態與否
        } catch (error) {
            console.error('檢查登入狀態失敗:', error);
            router.push('/');
            return false;
        }finally{
            isLoading.value = false
        }
    }
    return {
        isAuthenticated,
        userEmail,
        checkAuth,
        isLoading
    }
}
