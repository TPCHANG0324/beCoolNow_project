import { ref } from 'vue'
import { useRouter } from 'vue-router'

export function useAuth() {
    const router = useRouter()
    const isAuthenticated = ref(false)
    const userEmail = ref('')
    const isLoading = ref(false)

    const checkAuth = async () => {
        isLoading.value = true
        try {
            const res = await fetch('/tid103/g1/php/checkLogin.php', {
                credentials: 'include'
            });
            const data = await res.json();
            isAuthenticated.value = data.success
            userEmail.value = data.success ? data.email : ''
            return data.success //返回登入狀態與否
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