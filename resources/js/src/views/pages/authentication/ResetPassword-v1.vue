<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">
      <!-- Reset Password v1 -->
      <b-card class="mb-0">

        <!-- logo -->
        <b-link class="brand-logo">
            <b-img
                :src="logoUrl"
                alt="Login V2"
                class="z-index-0"
                width="150"
                height="45"
            />

        </b-link>

        <b-card-title class="mb-1">
          Reset Password 🔒
        </b-card-title>
        <b-card-text class="mb-2">
          Your new password must be different from previously used passwords
        </b-card-text>

        <!-- form -->
        <validation-observer ref="simpleRules">
          <b-form
            method="POST"
            class="auth-reset-password-form mt-2"
            @submit.prevent="validationForm"
          >

              <!-- password -->
            <b-form-group
              label="New Password"
              label-for="reset-password-new"
            >
              <validation-provider
                #default="{ errors }"
                name="Password"
                vid="Password"
                rules="required|password"
              >
                <b-input-group
                  class="input-group-merge"
                  :class="errors.length > 0 ? 'is-invalid':null"
                >
                  <b-form-input
                    id="reset-password-new"
                    v-model="resetData.password"
                    :type="password1FieldType"
                    :state="errors.length > 0 ? false:null"
                    class="form-control-merge"
                    name="reset-password-new"
                    placeholder="············"
                  />
                  <b-input-group-append is-text>
                    <feather-icon
                      class="cursor-pointer"
                      :icon="password1ToggleIcon"
                      @click="togglePassword1Visibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- confirm password -->
            <b-form-group
              label-for="reset-password-confirm"
              label="Confirm Password"
            >
              <validation-provider
                #default="{ errors }"
                name="Confirm Password"
                rules="required|confirmed:Password"
              >
                <b-input-group
                  class="input-group-merge"
                  :class="errors.length > 0 ? 'is-invalid':null"
                >
                  <b-form-input
                    id="reset-password-confirm"
                    v-model="resetData.cPassword"
                    :type="password2FieldType"
                    class="form-control-merge"
                    :state="errors.length > 0 ? false:null"
                    name="reset-password-confirm"
                    placeholder="············"
                  />
                  <b-input-group-append is-text>
                    <feather-icon
                      class="cursor-pointer"
                      :icon="password2ToggleIcon"
                      @click="togglePassword2Visibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- submit button -->
            <b-button
              block
              type="submit"
              variant="primary"

            >
              Set New Password
            </b-button>
          </b-form>
        </validation-observer>

        <p class="text-center mt-2">
          <b-link :to="{name:'auth-login'}">
            <feather-icon icon="ChevronLeftIcon" /> Back to login
          </b-link>
        </p>

      </b-card>
    <!-- /Reset Password v1 -->
    </div>
  </div>

</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BCard,
  BCardTitle,
  BCardText,
  BForm,
  BFormGroup,
  BInputGroup,
  BInputGroupAppend,
  BLink,
  BFormInput,
  BButton,
    BImg
} from 'bootstrap-vue'
import { required } from '@validations'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import axios from 'axios'
import {ref} from "@vue/composition-api";
import router from 'vue-router';

export default {
  components: {
    BCard,
    BButton,
    BCardTitle,
    BCardText,
    BForm,
    BFormGroup,
    BInputGroup,
    BLink,
    BFormInput,
    BInputGroupAppend,
      BImg,

    ValidationProvider,
    ValidationObserver,
  },
    created() {
        var url = window.location.href;
        var url_token = url.split('/', -1)
        this.resetData.token = ref(url_token[4]);
        this.resetData.email = ref(url_token[5]);
    },
    setup() {
      const resetDataBlank = {
            email: '',
            password: '',
            cPassword: '',
            token: '',
        }

        const resetData = ref(JSON.parse(JSON.stringify(resetDataBlank)))

        const logoUrl =  require('@/assets/images/logo/logo.png')
        const password1FieldType =  'password'
        const password2FieldType =  'password'



        function togglePassword1Visibility() {
            this.password1FieldType = this.password1FieldType === 'password' ? 'text' : 'password'
        }
        function togglePassword2Visibility() {
            this.password2FieldType = this.password2FieldType === 'password' ? 'text' : 'password'
        }
        function validationForm() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                  this.$toast({
                    component: ToastificationContent,
                    props: {
                      title: 'Password Reset',
                      icon: 'EditIcon',
                      variant: 'success',
                    },
                  })
                    console.log(resetData.value)
                    debugger
                    axios.post('/api/resetPassword', resetData.value )
                        .then(response => {
                            console.log(response)
                            debugger


                         this.$router.push('/login')
                        })
                        .catch((err) => {
                            console.log(err)
                            debugger
                            if (error.response.status === 404) {
                                resetData.value = undefined
                            }
                            debugger
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Error Resetting Password',
                                    icon: 'AlertTriangleIcon',
                                    variant: 'danger',
                                },
                            })
                        })
                }
            })
        }



        return {
            resetData,

            // userEmail,
            // cPassword,
            // password,
            // token,
            password1FieldType,
            password2FieldType,
            // validation
            required,
            logoUrl,

            // Toggle Password
            password1FieldType: 'password',
            password2FieldType: 'password',

            validationForm,
            togglePassword2Visibility,
            togglePassword1Visibility,

        }

    },
    computed: {
    password1ToggleIcon() {
      return this.password1FieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    password2ToggleIcon() {
      return this.password2FieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
}


</script>

<style lang="scss">
@import '~@core/scss/vue/pages/page-auth.scss';
</style>
