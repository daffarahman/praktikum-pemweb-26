<?php

class ThreadRenderer {
    private $csrfToken;
    private $replies;

    public function __construct($csrfToken, array $replies) {
        $this->csrfToken = $csrfToken;
        $this->replies = $replies;
    }

    public function render(Thread $thread, $level = 0) {
        $id = (int)$thread->id;
        $author = htmlspecialchars($thread->author_name, ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($thread->content, ENT_QUOTES, 'UTF-8');
        $created_at_formatted = $thread->getFormattedCreatedAt();
        $updated_at_formatted = $thread->getFormattedUpdatedAt();
        ?>
        <div class="my-4">
            <div class="p-4 text-white">
                <div class="flex flex-wrap justify-between items-center mb-2 text-xs text-white">
                    <div class="flex flex-wrap items-center gap-2">
                        <strong class="text-[#FF246F] text-sm"><?php echo $author; ?></strong>
                        <span class="text-white tracking-wide"><?php echo $created_at_formatted; ?></span>
                        <?php if ($updated_at_formatted): ?>
                            <span class="text-white bg-[#AB1B4C] px-1 py-0.5 text-[11px]">Edited</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <p class="text-white text-base whitespace-pre-wrap my-3 select-text font-serif"><?php echo $content; ?></p>
                
                <!-- Actions panel -->
                <div class="flex flex-wrap gap-2 text-xs mt-3 pt-3">
                    <button onclick="toggleElement('reply-form-<?php echo $id; ?>')" class="bg-[#AB1B4C] text-white py-1 px-3 cursor-pointer">
                        Reply
                    </button>
                    <button onclick="toggleElement('edit-form-<?php echo $id; ?>')" class="text-white py-1 px-3 cursor-pointer">
                        Edit
                    </button>
                    <form method="POST" action="" onsubmit="return confirm('Delete this thread and all its replies?');" class="inline">
                        <input type="hidden" name="csrf_token" value="<?php echo $this->csrfToken; ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="thread_id" value="<?php echo $id; ?>">
                        <button type="submit" class="bg-[#390014] text-white py-1 px-3 cursor-pointer">
                            Delete
                        </button>
                    </form>
                </div>

                <!-- Reply Form -->
                <div id="reply-form-<?php echo $id; ?>" class="hidden mt-4 pt-4">
                    <h4 class="text-sm mb-2 text-white">Reply to #<?php echo $id; ?></h4>
                    <form method="POST" action="" class="space-y-3">
                        <input type="hidden" name="csrf_token" value="<?php echo $this->csrfToken; ?>">
                        <input type="hidden" name="action" value="create">
                        <input type="hidden" name="parent_id" value="<?php echo $id; ?>">
                        <div>
                            <label class="block text-xs mb-1 text-white">Name (Optional)</label>
                            <input type="text" name="author_name" placeholder="Anonymous" class="w-full p-2 bg-white text-[#AB1B4C] outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-xs mb-1 text-white">Reply Content</label>
                            <textarea name="content" required rows="3" placeholder="Write your anonymous reply here..." class="w-full p-2 bg-white text-[#AB1B4C] outline-none text-sm"></textarea>
                        </div>
                        <button type="submit" class="bg-[#AB1B4C] text-white py-2 px-4 text-sm cursor-pointer">
                            Post Reply
                        </button>
                    </form>
                </div>

                <!-- Edit Form -->
                <div id="edit-form-<?php echo $id; ?>" class="hidden mt-4 pt-4">
                    <h4 class="text-sm mb-2 text-white">Edit Thread #<?php echo $id; ?></h4>
                    <form method="POST" action="" class="space-y-3">
                        <input type="hidden" name="csrf_token" value="<?php echo $this->csrfToken; ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="thread_id" value="<?php echo $id; ?>">
                        <div>
                            <label class="block text-xs mb-1 text-white">Name (Optional)</label>
                            <input type="text" name="author_name" value="<?php echo htmlspecialchars($thread->author_name, ENT_QUOTES, 'UTF-8'); ?>" class="w-full p-2 bg-white text-[#AB1B4C] outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-xs mb-1 text-white">Content</label>
                            <textarea name="content" required rows="3" class="w-full p-2 bg-white text-[#AB1B4C] outline-none text-sm"><?php echo htmlspecialchars($thread->content, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                        <button type="submit" class="bg-[#AB1B4C] text-white py-2 px-4 text-sm cursor-pointer">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Children replies wrapper -->
            <?php if (isset($this->replies[$id])): ?>
                <div class="thread-replies-wrapper pl-6 my-2">
                    <?php
                    foreach ($this->replies[$id] as $reply) {
                        $this->render($reply, $level + 1);
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
