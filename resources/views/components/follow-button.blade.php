@props(['userId' => null, 'initialCount' => 0, 'variant' => 'default'])

<div x-data="{ 
    userId: {{ $userId ?? 'null' }},
    loading: false,
    
    async toggleFollow() {
        if (this.loading) return;
        
        const wasFollowing = $store.followStore.isFollowing(this.userId);
        
        // Optimistic Update
        this.loading = true;
        $store.followStore.toggle(this.userId);
        
        try {
            const response = await axios.post(`/users/${this.userId}/follow`);
            
            // Sync with server response
            $store.followStore.sync(this.userId, response.data.is_following);
            
            // Dispatch event for other components to listen to count changes if needed
            window.dispatchEvent(new CustomEvent('follow-updated', { 
                detail: { 
                    userId: this.userId, 
                    isFollowing: response.data.is_following,
                    followersCount: response.data.followers_count
                } 
            }));
        } catch (error) {
            // Rollback on failure
            $store.followStore.sync(this.userId, wasFollowing);
            console.error('Follow failed:', error);
        } finally {
            this.loading = false;
        }
    }
}" class="inline-block">
    
    @if($variant === 'profile')
        {{-- Profile style button --}}
        <button 
            @click="toggleFollow()"
            :disabled="loading"
            :class="$store.followStore.isFollowing(userId) 
                ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' 
                : 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100'"
            class="px-6 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2 disabled:opacity-50"
        >
            <template x-if="loading">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>
            <span x-text="$store.followStore.isFollowing(userId) ? 'Following' : 'Follow'"></span>
        </button>
    @else
        {{-- Standard style button (feed, sidebar) --}}
        <button 
            @click="toggleFollow()"
            :disabled="loading"
            :class="$store.followStore.isFollowing(userId) 
                ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' 
                : 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100'"
            class="py-1.5 px-4 rounded-full text-xs font-bold transition-all flex items-center gap-1 disabled:opacity-50 min-w-[80px] justify-center"
        >
            <template x-if="loading">
                <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>
            <span x-text="$store.followStore.isFollowing(userId) ? 'Following' : 'Follow'"></span>
        </button>
    @endif
</div>
