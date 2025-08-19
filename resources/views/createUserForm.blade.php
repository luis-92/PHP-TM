<div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1 class="mb-4">Crear usuario</h1>

            <!-- Mensajes de error -->
            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Mensajes de éxito -->
            <?php if (!empty($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="store_user.php">

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                required
                            >
                            <div class="form-text">Mínimo 8 caracteres.</div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rol</label>
                            <select id="role" name="role" class="form-select">
                                <option value="">Selecciona un rol…</option>
                                <option value="admin">Administrador</option>
                                <option value="member">Miembro</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Cancelar</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
