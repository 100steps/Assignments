
#import "ViewController.h"
#import "AppDelegate.h"
#import "Clothes+CoreDataProperties.h"
@interface ViewController ()<UITableViewDataSource,UITableViewDelegate>
@property (weak, nonatomic) IBOutlet UITableView *tableView;


@property (nonatomic,strong)NSMutableArray *dataSource;


//声明一个appDelegate对象属性
@property (nonatomic,strong)AppDelegate *myAppDelegate;
@end



@implementation ViewController

- (IBAction)addModel:(id)sender {
    //插入数据
    
    //创建实体描述对象
    NSEntityDescription *description = [NSEntityDescription entityForName:@"Clothes" inManagedObjectContext:self.myAppDelegate.managedObjectContext];
    
    //1.先创建一个模型对象
    Clothes *cloth = [[Clothes alloc]initWithEntity:description insertIntoManagedObjectContext:self.myAppDelegate.managedObjectContext];
    
    cloth.name = @"Puma";
    int price = arc4random() % 10 + 1;
    cloth.price = [NSNumber numberWithInt:price];
    //插入数据源数组
    [self.dataSource addObject:cloth];
    
    
    [self.tableView insertRowsAtIndexPaths:@[[NSIndexPath indexPathForRow:self.dataSource.count - 1 inSection:0]] withRowAnimation:UITableViewRowAnimationLeft];
    
    [self.myAppDelegate saveContext];
}

- (void)viewDidLoad {
    [super viewDidLoad];
    self.dataSource = [NSMutableArray array];
    self.myAppDelegate = [UIApplication sharedApplication].delegate;
    NSFetchRequest *request = [[NSFetchRequest alloc]initWithEntityName:@"Clothes"];
    NSSortDescriptor *sortDescriptor = [[NSSortDescriptor alloc]initWithKey:@"price" ascending:YES];
    request.sortDescriptors = @[sortDescriptor];
    NSError *error = nil;
    
    NSArray *result = [self.myAppDelegate.managedObjectContext executeFetchRequest:request error:&error];
    //给数据源数组添加数据
    [self.dataSource addObjectsFromArray:result];
}
#pragma mark - tableView的delegate 和 dataSource方法
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return self.dataSource.count;
}

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
    return 1;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"cell" forIndexPath:indexPath];
    
    Clothes *cloth = self.dataSource[indexPath.row];
    cell.textLabel.text = [NSString stringWithFormat:@"%@--%@",cloth.name,cloth.price];
    return cell;
}
- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath{
    return YES;
}
//tableView的编辑的方法
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        
        
        Clothes *cloth = self.dataSource[indexPath.row];
        
        
        [self.dataSource removeObject:cloth];
        
        //删除数据管理中的数据
        [self.myAppDelegate.managedObjectContext deleteObject:cloth];
        [self.myAppDelegate saveContext];
        [self.tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    }
}

//点击cell的方法来修改数据
- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    //1.先找到模型对象
    Clothes *cloth = self.dataSource[indexPath.row];
    cloth.name = @"Nick";
    //刷新单元行
    [self.tableView reloadRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationAutomatic];
    //通过saveContext方法对数据进行永久保存
    [self.myAppDelegate saveContext];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
