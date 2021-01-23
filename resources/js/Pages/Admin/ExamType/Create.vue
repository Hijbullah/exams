<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Create New Exam Type</h2>
            <div class="pt-5">
                <form @submit.prevent="createExamType">
                    <div class="flex flex-col ">
                        <div class="w-full">
                            <jet-label for="name" value="Exam Type" />
                            <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Exam Type..." autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                    </div>
                    <div class="mt-8">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </jet-button>
                        <jet-secondary-button @click.native.prevent="goBack">
                            Back
                        </jet-secondary-button>
                    </div>
                </form>
            </div>
        </div>
       
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            AdminLayout,
            JetInput,
            JetInputError,
            JetLabel,
            JetButton,
            JetSecondaryButton
        },
        
        data() {
            return {
                form: this.$inertia.form({
                    name: ''
                })
            }
        },
        methods: {
            createExamType(){
                 this.form.post(route('admin.exam-types.store'), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.exam-types.index'));
            }
        }
    }
</script>