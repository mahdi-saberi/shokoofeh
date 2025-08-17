<?php if($paginator->hasPages()): ?>
    <nav class="persian-pagination" role="navigation" aria-label="صفحه‌بندی">
        <div class="pagination-container">
            
            <?php if($paginator->onFirstPage()): ?>
                <span class="pagination-btn disabled" aria-disabled="true">
                    <i class="fas fa-chevron-right"></i>
                    <span>قبلی</span>
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="pagination-btn" rel="prev">
                    <i class="fas fa-chevron-right"></i>
                    <span>قبلی</span>
                </a>
            <?php endif; ?>

            <div class="pagination-numbers">
                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(is_string($element)): ?>
                        <span class="pagination-dots" aria-disabled="true"><?php echo e($element); ?></span>
                    <?php endif; ?>

                    
                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <span class="pagination-number active" aria-current="page"><?php echo e($page); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" class="pagination-number"><?php echo e($page); ?></a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="pagination-btn" rel="next">
                    <span>بعدی</span>
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php else: ?>
                <span class="pagination-btn disabled" aria-disabled="true">
                    <span>بعدی</span>
                    <i class="fas fa-chevron-left"></i>
                </span>
            <?php endif; ?>
        </div>

        
        <div class="pagination-info">
            <p class="pagination-results">
                نمایش
                <span class="pagination-count"><?php echo e($paginator->firstItem()); ?></span>
                تا
                <span class="pagination-count"><?php echo e($paginator->lastItem()); ?></span>
                از
                <span class="pagination-count"><?php echo e($paginator->total()); ?></span>
                نتیجه
            </p>
        </div>
    </nav>
<?php endif; ?>

<style>
.persian-pagination {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    margin: 2rem 0;
    direction: rtl;
}

.pagination-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--surface-color, #ffffff);
    padding: 0.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-color, #e2e8f0);
}

.pagination-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--primary-color, #FF6B35);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    min-width: 80px;
    justify-content: center;
}

.pagination-btn:hover {
    background: var(--primary-dark, #E55A30);
    transform: translateY(-1px);
    text-decoration: none;
    color: white;
}

.pagination-btn.disabled {
    background: var(--neutral-200, #e5e7eb);
    color: var(--text-tertiary, #9ca3af);
    cursor: not-allowed;
    transform: none;
}

.pagination-numbers {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.pagination-number {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--neutral-100, #f8f9fa);
    color: var(--text-primary, #1f2937);
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 1px solid var(--border-color, #e2e8f0);
}

.pagination-number:hover {
    background: var(--primary-color, #FF6B35);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.pagination-number.active {
    background: var(--primary-color, #FF6B35);
    color: white;
    border-color: var(--primary-color, #FF6B35);
    box-shadow: 0 2px 4px rgba(255, 107, 53, 0.3);
}

.pagination-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    color: var(--text-tertiary, #9ca3af);
    font-weight: 500;
}

.pagination-info {
    text-align: center;
}

.pagination-results {
    color: var(--text-secondary, #6b7280);
    font-size: 0.9rem;
    margin: 0;
}

.pagination-count {
    font-weight: 600;
    color: var(--primary-color, #FF6B35);
}

/* Responsive Design */
@media (max-width: 768px) {
    .pagination-container {
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    .pagination-btn {
        min-width: 60px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .pagination-btn span {
        display: none;
    }

    .pagination-number {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .pagination-numbers {
        max-width: 200px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .pagination-numbers::-webkit-scrollbar {
        display: none;
    }
}
</style>
<?php /**PATH /var/www/resources/views/pagination/persian.blade.php ENDPATH**/ ?>