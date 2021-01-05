<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <?php if (isset($notice)) :
                    if (isset($notice[0]) && is_array($notice[0])) :
                        foreach ($notice as $n) :
                ?>
                            <div class="alert alert-<?php echo isset($n['tipe']) ? $n['tipe'] : 'warning' ?> alert-dismissible fade show" role="alert">
                                <strong><?php echo isset($n['title']) ? $n['title'] : null ?></strong> <?php echo isset($n['message']) ? $notice['message'] : null ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="alert alert-<?php echo isset($notice['tipe']) ? $notice['tipe'] : 'warning'?> alert-dismissible fade show" role="alert">
                            <strong><?php echo isset($notice['title']) ? $notice['title'] : null ?></strong> <?php echo isset($notice['message']) ? $notice['message'] : null ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                <div class="table-responsive">
                    <table id="<?php echo $dtid ?>">
                        <thead>
                            <tr>
                                <?php foreach (array_keys($headmapping) as $h) : ?>
                                    <th><?php echo $h ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dtdata as $d) : ?>
                                <tr>
                                    <?php foreach ($headmapping as $k => $v) : ?>
                                        <?php
                                        $teks = '';
                                        $key = explode(';', $v);
                                        if (count($key) > 1) :
                                            foreach ($key as $k) :
                                                $temp = (empty($d[$k]) || in_array($d[$k], $notAllowwed)) && isset($penggantidatakosong) ? $penggantidatakosong : $d[$k];
                                                $teks .= ' ' . $temp;
                                        ?>
                                            <?php endforeach ?>
                                        <?php else : $teks = empty($d[$v]) && isset($penggantidatakosong) ? $penggantidatakosong : $d[$v] ?>
                                        <?php endif ?>
                                        <td <?php echo isset($link) && $link == $k ? 'class="item" style="cursor:pointer" data-item = "' . $d[$dataitem] . '"' : null ?>><?php echo $teks ?></td>
                                    <?php endforeach ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>