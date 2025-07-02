<template>
  <div class="modal">
    <div class="form-container">
      <h3>{{ title }}</h3>
      <form @submit.prevent="submit">
        <div v-for="field in fields" :key="field.name" class="form-group">
          <label>{{ field.label }}</label>
          <input
            v-if="field.type === 'input'"
            v-model="form[field.name]"
            type="text"
            class="form-control"
          />

          <select
            v-else-if="field.type === 'select'"
            v-model="form[field.name]"
            class="form-control"
          >
            <template v-if="field.options">
              <option
                v-for="option in field.options"
                :key="option.id"
                :value="option.value"
              >
                {{ option.label }}
              </option>
            </template>
          </select>
          <textarea v-else v-model="form[field.name]" class="form-control" />
        </div>
        <div class="form-actions">
          <button type="submit">Save</button>
          <button type="button" @click="$emit('close')">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch } from "vue";

const props = defineProps({
  modelValue: Object,
  fields: Array,
  title: String,
});

const emit = defineEmits(["submit", "close"]);

const form = reactive({});

watch(
  () => props.modelValue,
  (newVal) => {
    if (newVal) {
      Object.assign(form, JSON.parse(JSON.stringify(newVal)));
    }
  },
  { immediate: true }
);

const submit = () => {
  emit("submit", { ...form });
  emit("close");
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.form-container {
  background: white;
  padding: 20px 30px;
  border-radius: 8px;
  width: 400px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

h3 {
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: 600;
  font-size: 14px;
}

input.form-control,
select.form-control,
textarea.form-control {
  padding: 8px 12px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
}

textarea {
  font-family: inherit;
}

.form-actions {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 25px;
}

.form-actions button {
  padding: 8px 25px;
  font-size: 14px;
  border-radius: 4px;
  border: none;
  cursor: pointer;
}

.form-actions button[type="submit"] {
  background-color: #409eff;
  color: white;
}

.form-actions button[type="submit"]:hover {
  background-color: #66b1ff;
}

.form-actions button[type="button"] {
  background-color: #eee;
  color: #333;
}

.form-actions button[type="button"]:hover {
  background-color: #ddd;
}

@media (max-width: 768px) {
  .form-container {
    width: 300px;
  }
  input.form-control,
  select.form-control,
  textarea.form-control {
    font-size: 12px;
  }
  .form-group label {
    font-size: 12px;
  }
  h3 {
    font-size: 16px;
  }
}
</style>
