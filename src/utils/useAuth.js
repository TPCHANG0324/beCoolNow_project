import { ref } from 'vue'
import { useRouter } from 'vue-router'

export function useAuth() {
    const router = useRouter()
    const isAuthenticated = ref(false)
    const userEmail = ref('')

    const checkAuth = async () => {
        try {
            const res = await fetch('/tid103/g1/php/checkLogin.php', {
                credentials: 'include'
            });
            const data = await res.json();

            isAuthenticated.value = data.success
            userEmail.value = data.success ? data.email : ''
            return data.success //返回登入狀態與否

            //   if (data.success) {
            //     isAuthenticated.value = true;
            //     userEmail.value = data.email;
            //     return true;
            //   } else {
            //     //顯示popup燈箱
            //     // router.push('/');
            //     return false;
            //   }
        } catch (error) {
            console.error('檢查登入狀態失敗:', error);
            router.push('/');
            return false;
        }
    }
    return {
        isAuthenticated,
        userEmail,
        checkAuth
    }
}