<template>
    <div :class="'form-group col-md-' + width">
        <label v-if="label"
               :class="errors.length > 0 ? 'text-danger' : ''"
               :for="id">{{ label }}</label>
        <input :type="type"
               :id="id"
               :name="name"
               :class="errors.length > 0 ? 'is-invalid ' + className : className"
               :value="value"
               :placeholder="placeholder"
               v-on:input="$emit('input', $event.target.value)" />
        <ul v-if="errors">
            <li v-for="error in errors" class="text-danger"><strong>{{ error }}</strong></li>
        </ul>
    </div>

</template>

<script>
  export default {
    name: "input-component",
    props: {
      type: {
        type: String,
        required: false,
        default: 'text'
      },
      id: {
        type: String,
        required: false,
        default: '',
      },
      name: {
        type: String,
        required: false,
        default: '',
      },
      className: {
        type: String,
        required: false,
        default: 'form-control',
      },
      value: {
        type: String,
        default: '',
      },
      placeholder: {
        type: String,
        default: '',
      },
      label: {
        type: String,
        required: false,
        default: '',
      },
      width: {
        type: Number,
        required: true,
      },
      errors: {
        type: String,
        required: false,
        default: '',
      },
    },
  }
</script>

<style scoped>

</style>