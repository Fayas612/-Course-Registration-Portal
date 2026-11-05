from pathlib import Path
import os
import zipfile
import hashlib

root = Path(__file__).resolve().parent
out = root / 'output' / 'FullStack_Assessment_Package.zip'
files = [root / 'README.md', root / '.gitignore', root / '.gitattributes', root / 'Start-Portal.ps1', root / 'output/Answer_Script.pdf', root / 'output/Answer_Script.md']
for optional in ['output/Answer_Script.docx', 'output/CoursePath_Source.bundle']:
    if (root / optional).exists():
        files.append(root / optional)
for folder in ['portal', 'practicals', 'docs', '.github']:
    for current, dirs, names in os.walk(root / folder):
        dirs[:] = [d for d in dirs if d not in {'vendor', 'node_modules', '.git', 'dist', '__pycache__'}]
        for name in names:
            p = Path(current) / name
            rel = p.relative_to(root).as_posix()
            if name.startswith('.env') and name != '.env.example':
                continue
            if name.endswith(('.sqlite', '.sqlite-shm', '.sqlite-wal', '.log')) or name == '.phpunit.result.cache':
                continue
            if rel.startswith(('portal/bootstrap/cache/', 'portal/storage/')) and name != '.gitignore':
                continue
            files.append(p)
with zipfile.ZipFile(out, 'w', compression=zipfile.ZIP_DEFLATED, compresslevel=9) as z:
    for p in sorted(set(files)):
        z.write(p, 'FullStack_Assessment/' + p.relative_to(root).as_posix())
with zipfile.ZipFile(out) as z:
    assert z.testzip() is None
    names = z.namelist()
    for required in ['portal/artisan', 'portal/composer.lock', 'portal/.env.example', 'portal/database/schema.sql', 'practicals/C5/package-lock.json', 'output/Answer_Script.pdf', 'docs/VERIFICATION.md']:
        assert 'FullStack_Assessment/' + required in names, required
    assert not any('/vendor/' in n or '/node_modules/' in n or n.endswith('/.env') or n.endswith('.sqlite') for n in names)
    print(f'Archive verified: {len(names)} files, {out.stat().st_size:,} bytes')
    print(out)
digest = hashlib.sha256(out.read_bytes()).hexdigest()
(root/'output/FullStack_Assessment_Package.sha256').write_text(digest+'  '+out.name+'\n',encoding='ascii')
