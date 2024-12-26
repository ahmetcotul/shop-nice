<script setup>
import { ref ,onMounted} from 'vue';
import Cookies from 'js-cookie';
import { useRouter } from 'vue-router';

const userName = ref('');
const userEmail= ref('');
const isLoggedIn = ref(false);
const router = useRouter();

const checkAuthStatus= async()=>{
    const token = Cookies.get('authToken');
    if(token){
        try{
            const response = await fetch('http://localhost:8000/api/auth/validate', {
                method: 'GET',
                headers: {
                    Authorization: `Bearer ${token}`, 
                },
            });
            if (response.ok) {
                const data = await response.json();
                isLoggedIn.value = true; 
                userName.value = data.user.name; 
                userEmail.value= data.user.email;
                console.log(data.user);
            } else {
                isLoggedIn.value = false; 
            }

        }catch (error) {
                console.error('An error:', error);
                isLoggedIn.value = false;
        }
    }

}
const logout = () => {
    Cookies.remove('authToken');

    isLoggedIn.value = false;
    userName.value = '';
    window.location.reload();
};  
onMounted(() => {
  checkAuthStatus();
});
</script>
<template>
<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="../assets/pc.png" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Shop Nice</span>
            <span class="text-sm">The True Address for All Things Computers...</span>
        </a>
        <div class="flex items-center space-x-6 rtl:space-x-reverse">
            <a href="mailto:shopnice@info.com" class="text-sm  text-gray-500 dark:text-white hover:underline">shopnice@info.com</a>
            <router-link v-if="isLoggedIn" to="/cart" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">Cart</router-link>
            <router-link v-if="isLoggedIn && userEmail !== 'admin@shop'" to="/user" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">{{ userName }}</router-link>

            <router-link 
            v-if="isLoggedIn && userEmail === 'admin@shop'" 
            to="/admin-panel" 
            class="text-sm text-blue-600 dark:text-blue-500 hover:underline">
            Admin Panel
            </router-link>
            
            <button v-if="isLoggedIn" @click="logout" class="text-sm  text-red-600 dark:text-blue-500 hover:underline">Log Out</button>

            <router-link v-else  to="login" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">Login</router-link>
            
        </div>
    </div>
</nav>
<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline">Laptop</router-link>
                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline">Desktop</router-link>
                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline">Mainboard</router-link>
                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline">Ram</router-link>
                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline">HDD</router-link>
                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline"> SSD</router-link>

                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline"> GPU</router-link>

                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline"> CPU</router-link>

                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline"> Monitor</router-link>

                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline"> Keyboard</router-link>

                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline"> Mouse</router-link>

                </li>
                <li>
                    <router-link href="#" class="text-gray-900 dark:text-white hover:underline"> Power</router-link>

                </li>

            </ul>
        </div>
    </div>
</nav>

</template>
