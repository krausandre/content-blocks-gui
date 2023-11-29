<template>
  <form>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input class="form-control" id="vendor" aria-describedby="name"
             :value="contentBlockStore.getContentBlock.name"
      >
    </div>
    <div class="mb-3">
      <label for="group" class="form-label">Group</label>
      Group
      <input class="form-control" id="group" aria-describedby="group">
    </div>
    <div class="mb-3">
      <label for="typename" class="form-label">Type Name</label>
      <input class="form-control" id="typename" aria-describedby="typename">
    </div>
    <div class="mb-3">
      <label for="table" class="form-label">Table</label>
      <input class="form-control" id="table" aria-describedby="table">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>

<script setup>
import {useContentBlockStore} from "@/store/contentBlockStore";
const contentBlockStore = useContentBlockStore();
</script>

<style scoped>
</style>
